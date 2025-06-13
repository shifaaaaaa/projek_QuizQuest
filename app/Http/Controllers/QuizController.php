<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Choice;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::all();

        return view('admin.quizzes.index', ['quizzes' => $quizzes]);
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
            $question = Question::create([
                'quiz_id' => $quiz->id,
                'question' => $questionData['question'],
                'correct' => $questionData['correct'],
            ]);

            foreach ($questionData['options'] as $key => $choice) {
                Choice::create([
                    'question_id' => $question->id,
                    'choice_key' => $key,
                    'choice' => $choice,
                    'is_correct' => $questionData['correct'] == $key,
                ]);
            }
        }

        return redirect('/admin/quizzes')->with('success', 'Quiz successfully created');
    }
}

