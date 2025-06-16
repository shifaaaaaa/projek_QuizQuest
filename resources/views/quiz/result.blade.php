@extends('layouts.app')

@section('title', 'Hasil Quiz - ' . $result->quiz->title)

@push('styles')
<style>
body {
    background: linear-gradient(to right, var(--bright1), var(--bright2)) !important;
    color: var(--dark4) !important;
    min-height: 100vh;
}

.result-container {
    max-width: 800px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.result-header {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
    text-align: center;
}

.score-circle {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 2rem;
    font-weight: bold;
    color: white;
}

.score-excellent { background: #28a745; }
.score-good { background: #17a2b8; }
.score-average { background: #ffc107; color: #333; }
.score-poor { background: #dc3545; }

.result-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin: 2rem 0;
}

.stat-card {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    color: var(--dark2);
}

.stat-label {
    color: #666;
    margin-top: 0.5rem;
}

.answers-review {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
}

.answer-item {
    padding: 1rem;
    border-bottom: 1px solid #eee;
    margin-bottom: 1rem;
}

.answer-item:last-child {
    border-bottom: none;
}

.answer-correct {
    border-left: 4px solid #28a745;
    background: #f8fff9;
}

.answer-incorrect {
    border-left: 4px solid #dc3545;
    background: #fff8f8;
}

.question-text {
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.answer-details {
    font-size: 0.9rem;
    color: #666;
}

.action-buttons {
    text-align: center;
    margin-top: 2rem;
}

.btn {
    padding: 0.8rem 2rem;
    margin: 0 0.5rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
}

.btn-primary {
    background: var(--dark2);
    color: white;
}

.btn-primary:hover {
    background: var(--dark3);
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
}

/* Dark Mode */
body.dark-mode {
    background: linear-gradient(to right, var(--dark2), var(--dark3)) !important;
    color: var(--bright1) !important;
}

body.dark-mode .result-header,
body.dark-mode .stat-card,
body.dark-mode .answers-review {
    background: var(--dark4);
    color: var(--bright1);
}

body.dark-mode .answer-correct {
    background: rgba(40, 167, 69, 0.1);
}

body.dark-mode .answer-incorrect {
    background: rgba(220, 53, 69, 0.1);
}
</style>
@endpush

@section('content')
<div class="result-container">
    <div class="result-header">
        <h1>Hasil Quiz: {{ $result->quiz->title }}</h1>
        
        @php
            $scoreClass = 'score-poor';
            $scoreText = 'Perlu Belajar Lagi';
            if ($result->score >= 80) {
                $scoreClass = 'score-excellent';
                $scoreText = 'Excellent!';
            } elseif ($result->score >= 70) {
                $scoreClass = 'score-good';
                $scoreText = 'Good Job!';
            } elseif ($result->score >= 60) {
                $scoreClass = 'score-average';
                $scoreText = 'Not Bad';
            }
        @endphp
        
        <div class="score-circle {{ $scoreClass }}">
            {{ $result->score }}%
        </div>
        <h2>{{ $scoreText }}</h2>
        <p>Dikerjakan pada: {{ $result->completed_at->format('d M Y, H:i') }}</p>
    </div>

    <div class="result-stats">
        <div class="stat-card">
            <div class="stat-number">{{ $result->score }}%</div>
            <div class="stat-label">Skor Akhir</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $result->correct_answers }}</div>
            <div class="stat-label">Jawaban Benar</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $result->total_questions - $result->correct_answers }}</div>
            <div class="stat-label">Jawaban Salah</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ gmdate('i:s', $result->time_taken) }}</div>
            <div class="stat-label">Waktu Pengerjaan</div>
        </div>
    </div>

    <div class="answers-review">
        <h3>Review Jawaban</h3>
        @foreach($result->answers as $index => $answer)
        <div class="answer-item {{ $answer['is_correct'] ? 'answer-correct' : 'answer-incorrect' }}">
            <div class="question-text">
                {{ $index + 1 }}. {{ $answer['question'] }}
            </div>
            <div class="answer-details">
                <strong>Jawaban Anda:</strong> 
                {{ $answer['user_answer'] ? $answer['user_answer'] : 'Tidak dijawab' }}
                <br>
                <strong>Jawaban Benar:</strong> {{ $answer['correct_answer'] }}
                <br>
                <span style="color: {{ $answer['is_correct'] ? '#28a745' : '#dc3545' }}">
                    {{ $answer['is_correct'] ? '✓ Benar' : '✗ Salah' }}
                </span>
            </div>
        </div>
        @endforeach
    </div>

    <div class="action-buttons">
        <a href="{{ route('user.history') }}" class="btn btn-primary">Lihat Riwayat</a>
        <a href="{{ route('user.browse') }}" class="btn btn-secondary">Kembali ke Daftar Quiz</a>
    </div>
</div>
@endsection
