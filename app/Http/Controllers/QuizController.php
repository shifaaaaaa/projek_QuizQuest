<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Choice;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index(){
        $quizzes = Quiz::orderBy('created_at', 'desc')->get();
        
        $user = Auth::user();
        $completedQuizzes = [];

        if ($user) {
            $completedQuizzes = QuizResult::where('user_id', $user->id)
                                        ->get()
                                        ->keyBy('quiz_id');
        }

        $quizzes = Quiz::withCount('questions')->latest()->get();
        return view('admin.quizzes.index', compact('quizzes'));
    }

        public function preview($id)
    {
        $quiz = Quiz::findOrFail($id);
        $question_count = $quiz->questions()->count();
        return view('quiz.preview', [
            'quiz' => $quiz,
            'question_count' => $question_count
        ]);
    }

    public function start($id)
    {
        $quiz = Quiz::with('questions.choices')->findOrFail($id);
        $user = Auth::user();
              

        if ($user->levelInfo && $user->levelInfo->level < $quiz->min_level) {
        return redirect()->route('user.browse')->with('error', 'Level kamu belum cukup untuk mengakses quiz ini.'); 
        }

        $existingResult = QuizResult::where('user_id', $user->id)
                                      ->where('quiz_id', $id)
                                      ->first();
        
        if ($existingResult) {
            return redirect()->route('quiz.result', $existingResult->id)
                            ->with('info', 'Anda sudah pernah mengerjakan kuis ini.');
        }

        return view('quiz.take', compact('quiz'));
    }

    public function edit($id)
    {
        $quiz = Quiz::with('questions.choices')->findOrFail($id);
        return view('admin.quizzes.edit', compact('quiz'));
    }


    public function submit(Request $request, $id)
    {
        $quiz = Quiz::with('questions.choices')->findOrFail($id);
        $answers = $request->input('answers', []);
        $timeStarted = $request->input('time_started');
        $timeTaken = time() - $timeStarted;
        
        $correctAnswers = 0;
        $totalQuestions = $quiz->questions->count();
        $detailedAnswers = [];

        foreach ($quiz->questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            $correctChoice = $question->choices->where('is_correct', true)->first();
            $isCorrect = ($userAnswer !== null && $correctChoice !== null && $userAnswer == $correctChoice->id);
            
            if ($isCorrect) {
                $correctAnswers++;
            }

            $detailedAnswers[] = [
                'question_id' => $question->id,
                'question' => $question->question,
                'user_answer' => $userAnswer,
                'correct_answer' => $correctChoice ? $correctChoice->choice_key : null,
                'is_correct' => $isCorrect
            ];
        }

        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 2) : 0;

        $quizResult = QuizResult::create([
            'user_id' => Auth::id(),
            'quiz_id' => $id,
            'score' => $score,
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
            'answers' => $detailedAnswers,
            'time_taken' => $timeTaken,
            'completed_at' => now()
        ]);

        // XP & Level Update
        $user = Auth::user();
        $userLevel = $user->levelInfo;

        if (!$userLevel) {
            $userLevel = new \App\Models\UserLevel([
                'level' => 1,
                'xp' => 0,
            ]);
            $user->levelInfo()->save($userLevel);
        }

        $earnedXp = 250;
        $userLevel->xp += $earnedXp;

        $levelUp = false;
        while ($userLevel->xp >= 100) {
            $userLevel->level += 1;
            $userLevel->xp -= 100;
            $levelUp = true;
        }

        $userLevel->save();

        // Kirim notifikasi ke session untuk tampil di view
        session()->flash('earned_xp', $earnedXp);
        if ($levelUp) {
            session()->flash('level_up', true);
        }

        return redirect()->route('quiz.result', $quizResult->id);
    }

    public function result($id)
    {
        $result = QuizResult::with(['quiz', 'user'])->findOrFail($id);
        
        if (!Auth::user()->is_admin && $result->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        return view('quiz.result', compact('result'));
    }

    public function history()
    {
        $results = QuizResult::with('quiz')
                                ->where('user_id', Auth::id())
                                ->orderBy('completed_at', 'desc')
                                ->paginate(10);

        return view('user.history', compact('results'));
    }

    public function create()
    {
        return view('admin.quizzes.create'); 
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions' => 'required|array',
            'min_level' => 'required|integer|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.options.A' => 'required|string',
            'questions.*.options.B' => 'required|string',
            'questions.*.options.C' => 'required|string',
            'questions.*.options.D' => 'required|string',
            'questions.*.correct' => 'required|in:A,B,C,D',
        ]);

        $quiz = Quiz::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'min_level' => $request->input('min_level'),
        ]);

        foreach ($request->input('questions') as $questionData) {
            $question = $quiz->questions()->create([
                'question' => $questionData['question'],
                'correct' => $questionData['correct'],
            ]);

            foreach ($questionData['options'] as $key => $choice) {
                $question->choices()->create([ 
                    'choice_key' => $key,
                    'choice' => $choice,
                    'is_correct' => $questionData['correct'] == $key,
                ]);
            }
        }

        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz successfully created');
    }

    public function update(Request $request, Quiz $quiz)
    {
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'min_level' => 'required|integer|min:1',
    ]);

    $quiz->update($validatedData);

    return redirect()->route('admin.quizzes.edit', $quiz)->with('success', 'Quiz details updated successfully!');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz berhasil dihapus');

    }
    
    public function browse()
    {
        $user = Auth::user();
        $userLevel = $user->levelInfo?->level ?? 1;
        $quizzes = Quiz::withCount('questions')->latest()->get();
        return view('user.browse', compact('quizzes', 'userLevel'));
    }
}

    