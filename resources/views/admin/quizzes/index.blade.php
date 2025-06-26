@extends('layouts.app')

@section('title', 'Manage Quizzes - Admin')

@push('styles')
<style>
    .manage-quiz-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 2rem;
    }
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid rgba(0,0,0,0.1);
    }
    body.dark-mode .page-header { border-bottom-color: rgba(255,255,255,0.1); }
    .page-header h1 { font-size: 2rem; font-weight: 700; margin: 0; }
    .create-quiz-btn {
        background-color: var(--bright2);
        color: var(--dark4);
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
    }

    .quizzes-table-wrapper {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    body.dark-mode .quizzes-table-wrapper { background-color: var(--dark4); }
    .quizzes-table { width: 100%; border-collapse: collapse; }
    .quizzes-table th, .quizzes-table td { padding: 1rem 1.5rem; text-align: left; border-bottom: 1px solid #e9ecef; }
    body.dark-mode .quizzes-table th, body.dark-mode .quizzes-table td { border-bottom: 1px solid var(--dark3); }
    .quizzes-table th { background-color: #f8f9fa; }
    body.dark-mode .quizzes-table th { background-color: var(--dark3); }
    .action-btn {
        background-color: var(--dark1);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
    }
</style>
@endpush

@section('content')
<div class="manage-quiz-container">
    <div class="page-header">
        <h1>Manage Your Quizzes</h1>
        <a href="{{ route('admin.quizzes.create') }}" class="create-quiz-btn">+ Create New Quiz</a>
    </div>

    <div class="quizzes-table-wrapper">
        <table class="quizzes-table">
            <thead>
                <tr>
                    <th>Quiz Title</th>
                    <th>Questions</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($quizzes as $quiz)
                <tr>
                    <td>
                        <strong>{{ $quiz->title }}</strong><br>
                        <small style="opacity: 0.7;">{{ Str::limit($quiz->description, 70) }}</small>
                    </td>
                    <td>{{ $quiz->questions->count() }}</td>
                    <td>
                        <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="action-btn">Edit & Manage</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align: center; padding: 3rem;">
                        Belum ada kuis yang dibuat. Silakan klik tombol "Create New Quiz".
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection