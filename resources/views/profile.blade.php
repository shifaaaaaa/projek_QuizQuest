@extends('layouts.app')

@section('title', 'Profile - QuizQuest')

@push('styles')
<style>
  /* Specific styles for profile page */
  body { /* Overrides default layout body if needed, or ensure layout allows it */
    background: linear-gradient(to right, var(--bright2), var(--bright3));
  }
  body.dark-mode {
    background: linear-gradient(to right, var(--dark3), var(--dark4)); /* Ensure dark mode respects its specific gradient */
  }

  /* Header for this specific page, if different from app-header */
  .profile-page-header {
    background-color: var(--dark4);
    color: white;
    width: 100%;
    padding: 1.2rem;
    text-align: center;
    font-size: 1.5rem;
    font-weight: bold;
    /* margin-bottom: 1rem; /* If it's not the main app header */
  }

  .profile-container {
    background-color: white;
    color: var(--dark4); /* Text color for content inside profile container */
    margin: 2rem auto;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    width: 90%;
    max-width: 600px;
  }
  body.dark-mode .profile-container {
    background-color: var(--dark2); /* Dark mode background for container */
    color: white; /* Text color for dark mode */
  }

  .profile-header {
    text-align: center;
    margin-bottom: 2rem;
  }

  .profile-header h2 {
    color: var(--dark3);
  }
  body.dark-mode .profile-header h2 {
    color: var(--bright1);
  }

  .info-group {
    margin-bottom: 1.2rem;
  }

  .info-group label {
    font-weight: bold;
    display: block;
    margin-bottom: 0.3rem;
    color: var(--dark2);
  }
  body.dark-mode .info-group label {
    color: var(--bright2);
  }

  .info-group p {
    background-color: var(--bright1);
    padding: 0.7rem;
    border-radius: 8px;
    color: var(--dark4);
  }
  body.dark-mode .info-group p {
    background-color: var(--dark3);
    color: var(--bright1);
  }
</style>
@endpush

@section('content')
{{-- This page uses its own header style if not using the app-header from layout --}}
{{-- <header class="profile-page-header">
  Your Profile - QuizQuest
</header> --}}

<div class="profile-container">
  <div class="profile-header">
    {{-- Assuming $user object is passed from controller --}}
    <h2>Welcome, {{ $user->name ?? 'John Doe' }}!</h2>
  </div>
  <div class="info-group">
    <label>Username:</label>
    <p>{{ $user->username ?? 'johndoe123' }}</p>
  </div>
  <div class="info-group">
    <label>Email:</label>
    <p>{{ $user->email ?? 'johndoe@example.com' }}</p>
  </div>
  <div class="info-group">
    <label>Joined:</label>
    <p>{{ $user->created_at->format('F d, Y') }}</p>
  </div>
  <div class="info-group">
    <label>Quizzes Done:</label>
    <p>{{ $user->completedQuizzes->count() }}</p>
  </div>
</div>
@endsection