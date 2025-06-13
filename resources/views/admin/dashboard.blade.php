@extends('layouts.app')

@section('title', 'Admin Panel - QuizQuest')

@push('styles')
<style>
  body {
    margin: 0;
    color: white !important;
    background: linear-gradient(to right, var(--dark3), var(--dark4)) !important;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    font-family:'Quicksand', sans-serif;
}


  .admin-panel-title { 
    text-align: center;
    margin-top: 2rem;
    margin-bottom: 2rem;
    color: white; 
  }

  .admin-container {
    background-color: var(--dark2);
    padding: 2rem;
    border-radius: 12px;
    max-width: 800px;
    margin: auto;
    flex: 1; 
  }


  .admin-section {
    margin-bottom: 2rem;
  }

  .admin-section h2 {
    margin-bottom: 1rem;
    color: var(--bright1);
  }

  .admin-section button {
    background-color: var(--bright3);
    color: white;
    padding: 0.7rem 1.2rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  .admin-section button:hover {
    background-color: var(--bright2);
  }

  .warning {
    text-align: center;
    color: #ffc107;
    margin-top: 1rem;
  }
</style>
@endpush

@section('content')

<h1 class="admin-panel-title">Admin Control Panel</h1>
<div class="admin-container">
  <div class="admin-section">
    <h2>Manage Quizzes</h2>
    <button onclick="window.location.href='{{ url('/admin/quizzes') }}'">Open Quiz Manager</button>
  </div>

  <div class="admin-section">
    <h2>Set Game Rules</h2>
    <button onclick="window.location.href='{{ url('/admin/rules') }}'">Configure Rules</button> {{-- Assuming a route --}}
  </div>

  <div class="admin-section">
    <h2>Manage Users</h2>
    <button onclick="window.location.href='{{ url('/admin/users') }}'">Open User Manager</button> {{-- Assuming a route --}}
  </div>

  <div class="warning">
    This page is restricted to administrators only.
  </div>
</div>
@endsection