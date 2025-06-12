@extends('layouts.app') {{-- Keep extending layouts.app --}}

@section('title', 'Create Quiz - Admin QuizQuest')

@push('styles')
<style>
    /* Overriding body style from app.blade.php specifically for this page */
    body {
        background: linear-gradient(to right, var(--bright1), var(--bright2)) !important; /* Important to override layout */
        color: var(--dark4) !important;
        /* Remove padding: 2rem; if it's causing extra space around the main content area */
        /* min-height: 100vh; <-- Remove, handled by layouts.app */
        /* HAPUS BARIS DI BAWAH INI */
        /* display:block; */ /* Override flex from layout if it causes issues */
    }
    /* header.app-header, footer.app-footer { display: none; } */


    .create-quiz-title { /* Changed h1 to a class */
        text-align: center;
        margin-bottom: 2rem;
        color: var(--dark3);
    }

    .quiz-form {
        background-color: white;
        padding: 2rem;
        max-width: 700px;
        margin: auto;
        border-radius: 12px;
        box-shadow: 0 10px 18px rgba(0, 0, 0, 0.2);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        font-weight: bold;
        display: block;
        margin-bottom: 0.5rem;
        color: var(--dark2);
    }

    .form-group input[type="text"], /* More specific selector */
    .form-group textarea {
        width: 100%;
        padding: 0.8rem;
        border-radius: 8px;
        border: 1px solid var(--bright3);
        background-color: white; /* Ensure background is white */
        color: var(--dark4); /* Ensure text is dark */
    }

    .form-group button { /* General button in form-group */
        background-color: var(--dark2);
        color: white;
        padding: 0.8rem 1.6rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.3s ease;
    }
    .form-group button:hover {
        background-color: var(--dark3);
    }
    .form-group button[type="button"] { /* Specific for Add Question */
        background-color: var(--bright3); /* A different color to distinguish */
        color: var(--dark4);
    }
    .form-group button[type="button"]:hover {
        background-color: var(--bright2);
    }


    .question-section {
        margin-top: 2rem;
    }

    .question-box {
        border: 1px solid var(--bright3);
        padding: 1rem;
        margin-bottom: 1.2rem;
        border-radius: 8px;
        background-color: #f4fefe; /* Light background for question box */
    }
    .question-box label { /* Labels within question box */
        color: var(--dark2); /* Ensure label color is consistent */
    }
    .question-box input[type="text"] { /* Inputs within question box */
        background-color: white;
        color: var(--dark4);
        margin-bottom: 0.5rem; /* Add some spacing */
    }

    /* New style for remove button */
    .question-box .remove-question {
        background-color: #f05959; /* Red color for remove */
        color: white;
        border: none;
        padding: 0.4rem 0.8rem;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 0.5rem; /* Space above the button */
        display: block; /* Make it take full width */
        width: fit-content; /* Adjust width to content */
        margin-left: auto; /* Push to the right */
    }
    .question-box .remove-question:hover {
        background-color: #d43c3c;
    }
</style>
@endpush

@section('content')
<h1 class="create-quiz-title">Create New Quiz</h1>
<div class="quiz-form">
    <form action="{{ url('/admin/quizzes') }}" method="POST"> {{-- Example store route --}}
        @csrf
        <div class="form-group">
            <label for="title">Quiz Title</label>
            <input type="text" id="title" name="title" placeholder="Enter quiz title" value="{{ old('title') }}">
        </div>

        <div class="form-group">
            <label for="description">Quiz Description</label>
            <textarea id="description" name="description" rows="3" placeholder="Enter quiz description">{{ old('description') }}</textarea>
        </div>

        <div class="question-section" id="questions-container">
            {{-- Initial question box, name attributes are important for submission --}}
            <div class="question-box">
                <label for="questions[0][text]">Question 1</label>
                <input type="text" name="questions[0][text]" placeholder="Enter your question" value="{{ old('questions.0.text') }}">
                <label for="questions[0][answer]">Answer 1</label>
                <input type="text" name="questions[0][answer]" placeholder="Enter correct answer" value="{{ old('questions.0.answer') }}">
                {{-- Add fields for options if it's multiple choice --}}
            </div>
        </div>

        <div class="form-group">
            <button type="button" onclick="addQuestion()">+ Add Question</button>
        </div>

        <div class="form-group" style="text-align: center;">
            <button type="submit">Save Quiz</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    let questionCount = 1; // Assuming first question is already on page as 0-indexed in name
    function addQuestion() {
        const container = document.getElementById("questions-container");
        const div = document.createElement("div");
        div.classList.add("question-box");
        div.innerHTML = `
            <label for="questions[${questionCount}][text]">Question <span class="math-inline">\{questionCount \+ 1\}</label\>
<input type\="text" name\="questions\[</span>{questionCount}][text]" placeholder="Enter your question">
            <label for="questions[${questionCount}][answer]">Answer <span class="math-inline">\{questionCount \+ 1\}</label\>
<input type\="text" name\="questions\[</span>{questionCount}][answer]" placeholder="Enter correct answer">
            <button type="button" class="remove-question" onclick="removeQuestion(this)">Remove</button>
        `;
        container.appendChild(div);
        questionCount++;
    }

    function removeQuestion(button) {
        button.parentElement.remove();