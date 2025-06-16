@extends('layouts.app')

@section('title', 'Browse Quizzes - QuizQuest')

@push('styles')
<style>
  
  body {
    background: linear-gradient(to right, var(--bright1), var(--bright2)) !important;
    color: var(--dark4) !important;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    box-sizing: border-box;
    align-items: center;
    transition: background 0.3s, color 0.3s;
  }
  
  body.dark-mode {
    background: linear-gradient(to right, var(--dark2), var(--dark3)) !important;
    color: var(--bright1) !important;
  }

  .manage-quizzes-title {
    text-align: center;
    color: var(--dark3);
    margin-top: 2rem;  /* Tambahan margin-top 2rem */
    margin-bottom: 2rem;
  }
  body.dark-mode .manage-quizzes-title {
    color: var(--bright1);
  }
  
  .quiz-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); 
    gap: 1.5rem;
    max-width: 1000px;
    margin: auto;
    transition: color 0.3s, background 0.3s;
  }
  
  .quiz-card {
    background: #ffffff;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: color 0.3s, background 0.3s;
  }
  
  body.dark-mode .quiz-card {
    background: rgba(255, 255, 255, 0.05);
    color: var(--bright1);
    box-shadow: none;
    backdrop-filter: blur(10px);
  }
  
  .quiz-card h3 {
    color: var(--dark2);
    margin-bottom: 0.5rem;
    transition: color 0.3s;
  }
  
  body.dark-mode .quiz-card h3 {
    color: var(--bright1);
  }
  
  .quiz-card p {
    color: #555;
    font-size: 0.9rem;
    margin-bottom: 1rem;
    flex-grow: 1;
    transition: color 0.3s;
  }
  
  body.dark-mode .quiz-card p {
    color: #ccc;
  }
  
  .quiz-actions button, .quiz-actions .button-link {
    flex: 1;
    padding: 0.5rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    transition: background 0.3s, color 0.3s;
  }
  
  .edit { background: var(--dark1); color: #ffffff }
  .edit:hover { background: var(--dark2) }
  
  .delete { background: #f05959; color: #ffffff }
  .delete:hover { background: #d43c3c }
  
  .view { background: var(--bright3); color: #ffffff }
  .view:hover { background: var(--dark1) }
  
  body.dark-mode .edit { background: var(--dark3); color: var(--bright1) }
  body.dark-mode .edit:hover { background: var(--dark4) }
  
  body.dark-mode .delete { background: #ff7676; color: var(--dark4) }
  body.dark-mode .delete:hover { background: #ff5050 }
  
  body.dark-mode .view { background: var(--bright2); color: var(--dark4) }
  body.dark-mode .view:hover { background: var(--bright1) }
  
  .create-new {
    margin: 2rem auto 0;
    display: flex;
    justify-content: center;
  }
  
  .create-new a.button-link {
    background: var(--dark3);
    color: #ffffff;
    padding: 0.8rem 2rem;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    text-decoration: none;
    transition: background 0.3s ease;
  }
  
  .create-new a.button-link:hover {
    background: var(--dark4);
  }
  
  body.dark-mode .create-new a.button-link {
    background: var(--bright2);
    color: var(--dark4);
  }
  
  body.dark-mode .create-new a.button-link:hover {
    background: var(--bright1);
  }
</style>
@endpush

@section('content')
<h1 class="manage-quizzes-title">Browse Quizzes</h1>

<div class="quiz-list">
    {{-- Assuming $quizzes is passed from the controller --}}
        @forelse ($quizzes ?? [] as $quiz)
        <div class="quiz-card">
            <h3>{{ $quiz->title ?? 'Sample Quiz Title' }}</h3>
            <p>{{ $quiz->description ?? 'Sample quiz description.' }}</p>
            <div class="quiz-actions">
                <a href="{{ route('quiz.preview', ['id' => $quiz->id]) }}" class="button-link view">View</a>
            </div>
        </div>
    @empty
        <p>No quizzes found.</p>
    @endforelse
</div>

@endsection