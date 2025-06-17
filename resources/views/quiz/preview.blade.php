@extends('layouts.app')

@section('title', 'Preview Quiz - QuizQuest')

@push('styles')
<style>
body {
    background: linear-gradient(to right, var(--bright1), var(--bright2)) !important;
    color: var(--dark4) !important;
}

.content-wrapper {
    width: 100%;
    padding: 3rem 1rem;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.create-quiz-title { 
    text-align: center;
    margin-bottom: 2rem;
    color: var(--dark3);
}

.quiz-form {
    background-color: white;
    padding: 2rem;
    max-width: 700px;
    width: 100%;
    margin: 0 auto;
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

.form-group input[type="text"],
.form-group textarea {
    width: 100%;
    padding: 0.8rem;
    border-radius: 8px;
    border: 1px solid var(--bright3);
    background-color: #e9ecef;
    color: var(--dark4);
    cursor: not-allowed;
}

.info-display {
    width: 100%;
    padding: 0.8rem;
    border-radius: 8px;
    border: 1px solid var(--bright3);
    background-color: #e9ecef;
    color: var(--dark4);
    margin-top: 0;
    min-height: calc(1.5em + 1.6rem + 2px);
}

.button-group {
    text-align: center;
    display: flex;
    justify-content: space-between;
    gap: 20px;
    margin-top: 2rem;
}

.button-link {
    display: inline-block;
    padding: 0.8rem 1.6rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none;
    font-weight: bold;
    font-family: 'Quicksand', sans-serif;
    transition: 0.3s ease;
}

.button-link.primary {
    background-color: var(--dark2);
    color: white;
}
.button-link.primary:hover {
    background-color: var(--dark1);
}

.button-link.secondary {
    background-color: #6c757d;
    color: white;
}
.button-link.secondary:hover {
    background-color: #5a6268;
}

/* Dark Mode */
body.dark-mode {
    background: linear-gradient(to right, var(--dark2), var(--dark3)) !important;
    color: var(--bright1) !important;
}
body.dark-mode .create-quiz-title {
    color: var(--bright1);
}
body.dark-mode .quiz-form {
    background-color: var(--dark4);
    color: var(--bright1);
}
body.dark-mode .form-group label {
    color: var(--bright1);
}
body.dark-mode .form-group input[type="text"],
body.dark-mode .form-group textarea,
body.dark-mode .info-display {
    background: var(--dark3);
    color: var(--bright1);
    border: 1px solid var(--dark2);
}
body.dark-mode .button-link.primary {
    background: var(--bright2);
    color: var(--dark4);
}
body.dark-mode .button-link.primary:hover {
    background: var(--bright1);
}
body.dark-mode .button-link.secondary {
    background: var(--dark2);
    color: var(--bright1);
}
body.dark-mode .button-link.secondary:hover {
    background: var(--dark1);
}
</style>
@endpush

@section('content')
<div class="content-wrapper"> 
    <h1 class="create-quiz-title">Preview Quiz</h1>

    <div class="quiz-form">
        <div class="form-group">
            <label for="title">Quiz Title</label>
            <input type="text" id="title" readonly value="{{ $quiz->title }}">
        </div>

        <div class="form-group">
            <label for="description">Quiz Description</label>
            <textarea id="description" readonly>{{ $quiz->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="question_count">Jumlah Soal</label>
            <p id="question_count" class="info-display">{{ $question_count }} Soal</p>
        </div>

        <div class="button-group">
            @if (!Auth::user()->is_admin)
                <a href="{{ route('quiz.start', $quiz->id) }}" class="button-link primary">Start Quiz</a>
            @endif
            
            <a href="{{ Auth::user()->is_admin ? route('admin.quizzes.index') : url('/user/browse') }}" class="button-link secondary">
                Back
            </a>
        </div>
    </div>
</div>
@endsection
