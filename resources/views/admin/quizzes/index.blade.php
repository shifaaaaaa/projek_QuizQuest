@extends('layouts.app') {{-- Or an admin specific layout --}}

@section('title', 'Manage Quizzes - QuizQuest Admin')

@push('styles')
<style>
  /* Overriding body style from app.blade.php specifically for this page */
  body {
    background: linear-gradient(to right, var(--bright1), var(--bright2)) !important; /* Important to override layout */
    padding: 2rem;
    min-height: 100vh;
    color: var(--dark4) !important; /* Default text color for this page */
    display:block; /* Override flex from layout if it causes issues */
  }
  /* header.app-header, footer.app-footer { display: none; } */


  .manage-quizzes-title { /* Changed h1 to a class */
    text-align: center;
    color: var(--dark3);
    margin-bottom: 2rem;
  }

  .quiz-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    max-width: 1000px;
    margin: auto;
  }

  .quiz-card {
    background-color: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .quiz-card h3 {
    color: var(--dark2);
    margin-bottom: 0.5rem;
  }

  .quiz-card p {
    color: #555; /* Using a more specific dark grey */
    font-size: 0.9rem;
    margin-bottom: 1rem;
    flex-grow: 1; /* Allows description to take available space */
  }

  .quiz-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: auto; /* Pushes actions to the bottom */
  }

  .quiz-actions button, .quiz-actions .button-link { /* Style for both buttons and link-buttons */
    flex: 1;
    padding: 0.5rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
    text-align: center;
    text-decoration: none; /* For link-buttons */
    display: inline-block; /* For link-buttons */
    transition: background-color 0.3s;
  }

  .edit { background-color: var(--dark1); color: white; }
  .edit:hover { background-color: var(--dark2); }

  .delete { background-color: #f05959; color: white; }
  .delete:hover { background-color: #d43c3c; }

  .view { background-color: var(--bright3); color: white; } /* Changed to match original */
  .view:hover { background-color: var(--dark1); } /* Changed to match original */

  .create-new {
    margin: 2rem auto 0;
    display: flex;
    justify-content: center;
  }

  .create-new button, .create-new a.button-link { /* For button and link styled as button */
    background-color: var(--dark3);
    color: white;
    padding: 0.8rem 2rem;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    cursor: pointer;
    text-decoration: none;
    transition: 0.3s ease;
  }
  .create-new button:hover, .create-new a.button-link:hover {
    background-color: var(--dark4);
  }
</style>
@endpush

@section('content')
<h1 class="manage-quizzes-title">Manage Quizzes</h1>

<div class="quiz-list">
  {{-- Assuming $quizzes is passed from the controller --}}
  @forelse ($quizzes ?? [] as $quiz)
    <div class="quiz-card">
      <h3>{{ $quiz->title ?? 'Sample Quiz Title' }}</h3>
      <p>{{ $quiz->description ?? 'Sample quiz description.' }}</p>
      <div class="quiz-actions">
        <a href="{{ url('/admin/quizzes/' . ($quiz->id ?? '#') . '/edit') }}" class="button-link edit">Edit</a>
        <a href="{{ url('/admin/quizzes/' . ($quiz->id ?? '#')) }}" class="button-link view">View</a>
        <form action="{{ url('/admin/quizzes/' . ($quiz->id ?? '#')) }}" method="POST" style="display: contents;">
          @csrf
          @method('DELETE')
          <button type="submit" class="delete" onclick="return confirm('Are you sure you want to delete this quiz?')">Delete</button>
        </form>
      </div>
    </div>
  @empty
    {{-- Placeholder data if $quizzes is empty or not provided --}}
    <div class="quiz-card">
      <h3>Math Basics</h3>
      <p>A simple quiz on arithmetic and numbers.</p>
      <div class="quiz-actions">
        <a href="#" class="button-link edit">Edit</a>
        <a href="#" class="button-link view">View</a>
        <button type="button" class="delete">Delete</button>
      </div>
    </div>
    <div class="quiz-card">
      <h3>Science Facts</h3>
      <p>Test your general science knowledge.</p>
      <div class="quiz-actions">
        <a href="#" class="button-link edit">Edit</a>
        <a href="#" class="button-link view">View</a>
        <button type="button" class="delete">Delete</button>
      </div>
    </div>
     <p>No quizzes found.</p>
  @endforelse
</div>

<div class="create-new">
  <a href="{{ url('/admin/quizzes/create') }}" class="button-link">+ Create New Quiz</a>
</div>
@endsection