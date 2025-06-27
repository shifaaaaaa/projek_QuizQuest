@extends('layouts.app')
@section('title', 'Edit Quiz - ' . $quiz->title)

@push('styles')
<style>
    .edit-page-container { max-width: 900px; margin: 2rem auto; padding: 2rem; }
    .section-card {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        margin-bottom: 2rem;
    }
    body.dark-mode .section-card { background: var(--dark4); }
    .section-card h2 { font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem; }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: #f8f9fa;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus {
        outline: none;
        border-color: var(--bright2);
        box-shadow: 0 0 0 3px rgba(94, 190, 189, 0.25);
    }
    body.dark-mode .form-control {
        background-color: var(--dark3);
        border-color: var(--dark2);
        color: white;
    }
    
    .btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }
    .btn-primary {
        background-color: #6C63FF;
        color: white;
    }
    .btn-danger {
        background-color: #f05959;
        color: white;
    }

    .question-list { list-style: none; padding: 0; }
    .question-item {
        padding: 1rem;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        margin-bottom: 1rem;
    }
    body.dark-mode .question-item { border-color: var(--dark3); }
    .correct-answer { color: #28a745; font-weight: bold; }
    .danger-zone { border: 2px solid #f05959; }
    .danger-zone h2 { color: #f05959; }
</style>
@endpush

@section('content')
<div class="edit-page-container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- EDIT DETAIL KUIS --}}
    <div class="section-card">
        <h2>Edit Quiz Details</h2>
        <form action="{{ route('admin.quizzes.update', $quiz) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title" class="form-label">Quiz Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $quiz->title) }}" required>
            </div>
            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $quiz->description) }}</textarea>
            </div>
            <div class="form-group">
                <label for="min_level">Minimum Level</label>
                <input type="number" name="min_level" id="min_level" class="form-control" value="{{ old('min_level', $quiz->min_level) }}" required min="1">
            </div>
            <button type="submit" class="btn btn-primary">Update Details</button>
        </form>
    </div>

    {{-- DAFTAR SOAL --}}
    <div class="section-card">
        <h2>Questions ({{ $quiz->questions->count() }})</h2>
        <ul class="question-list">
            @forelse ($quiz->questions as $question)
            <li class="question-item">
                <strong>{{ $loop->iteration }}. {{ $question->question }}</strong>
                <br>
                <small>Jawaban Benar: 
                    <span class="correct-answer">
                        {{ $question->choices->where('is_correct', true)->first()->choice ?? 'Not Set' }}
                    </span>
                </small>
            </li>
            @empty
            <p>Belum ada soal untuk kuis ini.</p>
            @endforelse
        </ul>
    </div>
    

    {{-- HAPUS KUIS --}}
    <div class="section-card danger-zone">
        <h2>Danger Zone</h2>
        <p>Menghapus kuis tidak dapat dibatalkan. Semua soal dan riwayat pengerjaan pengguna yang terkait akan ikut terhapus.</p>
        <form action="{{ route('admin.quizzes.destroy', $quiz) }}" method="POST" onsubmit="return confirm('Apakah Anda benar-benar yakin ingin menghapus kuis ini secara permanen?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete This Quiz</button>
        </form>
    </div>
</div>
@endsection