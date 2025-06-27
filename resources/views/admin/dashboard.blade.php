@extends('layouts.app')

@section('title', 'Admin Panel - QuizQuest')

@push('styles')
<style>
  .admin-panel-title { 
    text-align: center;
    margin-top: 2rem;
    margin-bottom: 2rem;
  }
  body.dark-mode .admin-panel-title { color: white; }
  body:not(.dark-mode) .admin-panel-title { color: var(--dark4); }

  .admin-container {
    background-color: white;
    padding: 2rem;
    border-radius: 12px;
    max-width: 800px;
    margin: auto;
  }
  body.dark-mode .admin-container {
    background-color: var(--dark2);
  }

  .admin-section {
    margin-bottom: 2rem;
  }
  .admin-section h2 {
    margin-bottom: 1rem;
  }
  body:not(.dark-mode) .admin-section h2 { color: var(--dark3); }
  body.dark-mode .admin-section h2 { color: var(--bright1); }

  .admin-section button {
    background-color: var(--dark2);
    color: white;
    padding: 0.7rem 1.2rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  .admin-section button:hover {
    filter: brightness(120%);
  }
  body.dark-mode .admin-section button {
    background-color: var(--bright3);
    color: var(--dark4);
  }
</style>
@endpush

@section('content')
<h1 class="admin-panel-title">Admin Control Panel</h1>
<div class="admin-container">
  <div class="admin-section">
    <h2>Manage Quizzes</h2>
    <button onclick="window.location.href='{{ route('admin.quizzes.index') }}'">Open Quiz Manager</button>
  </div>

  <div class="admin-section">
    <h2>Set Game Rules</h2>
    <button onclick="window.location.href='{{ route('admin.rules.index') }}'">Configure Rules</button>
  </div>

  <div class="admin-section">
    <h2>Manage Users</h2>
    <button onclick="window.location.href='{{ route('admin.users.index') }}'">Open User Manager</button>
  </div>
</div>
@endsection