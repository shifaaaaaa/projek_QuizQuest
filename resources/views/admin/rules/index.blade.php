@extends('layouts.app')

@section('title', 'Set Game Rules - Admin')

@push('styles')
<style>
    .rules-page-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 2rem;
    }
    .rules-header h1 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    .rules-header p {
        font-size: 1.1rem;
        opacity: 0.8;
        margin-bottom: 2.5rem;
    }

    .settings-card {
        background-color: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }
    body.dark-mode .settings-card {
        background-color: var(--dark4);
    }

    .form-group {
        margin-bottom: 2rem;
    }
    .form-group label {
        font-weight: bold;
        display: block;
        margin-bottom: 0.75rem;
        font-size: 1.1rem;
    }
    .form-group input {
        width: 100%;
        padding: 0.8rem;
        border-radius: 8px;
        border: 1px solid var(--bright3);
        font-size: 1rem;
    }
    body.dark-mode .form-group input {
        background: var(--dark3);
        border-color: var(--dark2);
    }
    
    .form-group .helper-text {
        font-size: 0.9rem;
        color: #6c757d;
        display: block;
        margin-top: 0.5rem;
    }
    body.dark-mode .form-group .helper-text {
        color: var(--bright3);
    }

    .save-button {
        background-color: var(--dark2);
        color: white;
        padding: 0.8rem 2rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1rem;
        font-weight: bold;
    }
    body.dark-mode .save-button {
        background: var(--bright2);
        color: var(--dark4);
    }
</style>
@endpush

@section('content')
<div class="rules-page-container">

    <div class="rules-header">
        <h1>Game Rules & Settings</h1>
    </div>

    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <div class="settings-card">
        <form action="{{ route('admin.rules.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="quiz_time_limit">Batas Waktu Kuis</label>
                <input type="number" id="quiz_time_limit" name="quiz_time_limit" value="{{ old('quiz_time_limit', $rules['quiz_time_limit']) }}" required>
                <small class="helper-text">
                    Durasi dalam **menit** untuk setiap sesi kuis. Nilai saat ini: **{{ $rules['quiz_time_limit'] }} menit**.
                </small>
            </div>

            <div class="form-group">
                <label for="questions_per_quiz">Jumlah Pertanyaan per Kuis</label>
                <input type="number" id="questions_per_quiz" name="questions_per_quiz" value="{{ old('questions_per_quiz', $rules['questions_per_quiz']) }}" required>
                <small class="helper-text">
                    Jumlah pertanyaan yang akan ditampilkan di setiap sesi kuis. Nilai saat ini: **{{ $rules['questions_per_quiz'] }} pertanyaan**.
                </small>
            </div>

            <div style="text-align: right;">
                <button type="submit" class="save-button">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection