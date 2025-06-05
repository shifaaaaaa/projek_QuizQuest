@extends('layouts.app')

@section('title', 'QuizQuest - Home')

@push('styles')
<style>
  /* Styles specific to home page, body gradient is inherited or can be overridden */
  /* body { background: linear-gradient(to right, var(--bright1), var(--bright3)); } */
  /* body.dark-mode { background: linear-gradient(to right, var(--dark3), var(--dark4)); } */

  .home-main { /* Changed main to .home-main to avoid style conflicts if main tag has global styles */
    text-align: center;
    padding: 5rem 2rem;
  }

  button.toggle-dark {
    background-color: var(--bright2);
    color: var(--dark4); /* Ensure text is visible in light mode */
    border: none;
    padding: 0.6rem 1.2rem;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s ease;
  }

  button.toggle-dark:hover {
    background-color: var(--bright3);
  }

  body.dark-mode button.toggle-dark {
    background-color: var(--dark2); /* Adjust for dark mode */
    color: white;
  }
  body.dark-mode button.toggle-dark:hover {
    background-color: var(--dark1); /* Adjust for dark mode */
  }
</style>
@endpush

@section('content')
<div class="home-main">
  <h1>Welcome to QuizQuest</h1>
  <p>Challenge yourself with interactive quizzes and track your progress!</p>
  <button class="toggle-dark" onclick="toggleHomePageDarkMode()">Toggle Dark Mode</button>
</div>
@endsection

@push('scripts')
<script>
  function toggleHomePageDarkMode() {
    document.body.classList.toggle('dark-mode');
    localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
    // Optionally, you might want to notify the server to save this preference
  }

  // Override the global onload if needed or extend it
  // For this page, the global onload in app.blade.php handles initial dark mode loading
  // function pageOnLoad() {
  //    if (localStorage.getItem('darkMode') === 'true') {
  //        document.body.classList.add('dark-mode');
  //    }
  // }
</script>
@endpush