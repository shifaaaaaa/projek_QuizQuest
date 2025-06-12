@extends('layouts.app')

@section('title', 'QuizQuest - Dashboard')

@push('styles')
<style>

  .home-main {
    text-align: center;
    padding: 5rem 2rem;
  }

  button.toggle-dark {
    background-color: var(--bright2);
    color: var(--dark4);
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
    background-color: var(--dark2);
    color: white;
  }
  body.dark-mode button.toggle-dark:hover {
    background-color: var(--dark1);
  }
</style>
@endpush

@section('content')
<div class="home-main">
  <h1>ini adalah dashboard</h1>
</div>
@endsection

@push('scripts')
<script>
  function toggleHomePageDarkMode() {
    document.body.classList.toggle('dark-mode');
    localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
  }
</script>
@endpush