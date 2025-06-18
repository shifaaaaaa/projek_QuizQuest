@extends('layouts.app')

@section('title', 'Set Game Rules - Admin')

@push('styles')
<style>
    .rules-title {
        text-align: center;
        margin: 2rem 0;
        color: var(--dark3);
    }
    .rules-form-container {
        background-color: white;
        padding: 2rem;
        max-width: 600px;
        margin: auto;
        border-radius: 12px;
        box-shadow: 0 10px 18px rgba(0,0,0,0.2);
    }
    .form-group { margin-bottom: 1.5rem; }
    .form-group label {
        font-weight: bold;
        display: block;
        margin-bottom: 0.5rem;
    }
    .form-group input {
        width: 100%;
        padding: 0.8rem;
        border-radius: 8px;
        border: 1px solid var(--bright3);
    }
    .form-group small {
        color: #6c757d;
        display: block;
        margin-top: 0.25rem;
    }
    .form-group button {
        background-color: var(--dark2);
        color: white;
        padding: 0.8rem 1.6rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
    }
    
    /* Dark Mode */
    body.dark-mode .rules-title { color: var(--bright1); }
    body.dark-mode .rules-form-container { background-color: var(--dark4); }
    body.dark-mode .form-group label { color: var(--bright1); }
    body.dark-mode .form-group input {
        background: var(--dark3);
        color: var(--bright1);
        border: 1px solid var(--dark2);
    }
    body.dark-mode .form-group small { color: var(--bright3); }
    body.dark-mode .form-group button { background: var(--bright2); color: var(--dark4); }
</style>
@endpush

@section('content')
<h1 class="rules-title">Set Game Rules</h1>

<div class="rules-form-container">
    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.rules.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="quiz_time_limit">Batas Waktu Kuis</label>
            <input type="number" id="quiz_time_limit" name="quiz_time_limit" value="{{ old('quiz_time_limit', $rules['quiz_time_limit']) }}" required>
            <small>Durasi untuk setiap sesi kuis dalam satuan menit.</small>
        </div>

        <div class="form-group">
            <label for="questions_per_quiz">Jumlah Pertanyaan per Kuis</label>
            <input type="number" id="questions_per_quiz" name="questions_per_quiz" value="{{ old('questions_per_quiz', $rules['questions_per_quiz']) }}" required>
            <small>Jumlah pertanyaan yang akan ditampilkan di setiap sesi kuis.</small>
        </div>

        <div class="form-group">
            <button type="submit">Save Rules</button>
        </div>
    </form>
</div>
@endsection