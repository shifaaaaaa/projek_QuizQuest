<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Choice;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function store(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'question_text' => 'required|string|max:255',
            'choices' => 'required|array|min:2',
            'choices.*' => 'required|string|max:255',
            'correct_choice' => 'required|integer',
        ]);

        $question = $quiz->questions()->create([
            'question_text' => $validated['question_text']
        ]);

        foreach ($validated['choices'] as $index => $choiceText) {
            $isCorrect = ($index == $validated['correct_choice']);
            $question->choices()->create([
                'choice_text' => $choiceText,
                'is_correct' => $isCorrect,
            ]);
        }

        return back()->with('success', 'Question added successfully!');
    }
}