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
    public function index()
    {
        $quizzes = Quiz::latest()->get();

        if (Auth::user()->is_admin) {
            return view('admin.quizzes.index', compact('quizzes'));
        }

        $userResults = QuizResult::where('user_id', Auth::id())
                                 ->pluck('id', 'quiz_id');

        return view('user.browse', [
            'quizzes' => $quizzes,
            'userResults' => $userResults
        ]);
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
              
        $existingResult = QuizResult::where('user_id', Auth::id())
                                      ->where('quiz_id', $id)
                                      ->first();
        
        if ($existingResult) {
            return redirect()->route('quiz.result', $existingResult->id)
                            ->with('info', 'Anda sudah pernah mengerjakan kuis ini.');
        }

        return view('quiz.take', compact('quiz'));
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

    public function edit($id)
    {
        $quiz = Quiz::with('questions.choices')->findOrFail($id);
        return view('admin.quizzes.edit', compact('quiz'));
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        $quiz->questions()->delete();

        foreach ($request->input('questions') as $questionData) {
            $question = $quiz->questions()->create([
                'question' => $questionData['question'],
            ]);

            foreach ($questionData['options'] as $key => $choiceText) {
                $question->choices()->create([
                    'choice_key' => $key,
                    'choice' => $choiceText,
                    'is_correct' => ($questionData['correct'] == $key),
                ]);
            }
        }
        
        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz updated successfully');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz berhasil dihapus');
    }
}