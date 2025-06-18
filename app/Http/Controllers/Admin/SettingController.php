<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->keyBy('key');
        
        $rules = [
            'quiz_time_limit' => $settings->get('quiz_time_limit')->value ?? 10, // Default 10 menit
            'questions_per_quiz' => $settings->get('questions_per_quiz')->value ?? 20, // Default 20 pertanyaan
        ];

        return view('admin.rules.index', compact('rules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'quiz_time_limit' => 'required|integer|min:1',
            'questions_per_quiz' => 'required|integer|min:1',
        ]);

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('admin.rules.index')->with('success', 'Game rules updated successfully!');
    }
}