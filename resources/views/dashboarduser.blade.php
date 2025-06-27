@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
    /* Background Gradasi */
    body {
        background: linear-gradient(to right, var(--bright1), var(--bright2)) !important;
        color: var(--dark4) !important;
    }
    body.dark-mode {
        background: linear-gradient(to right, var(--dark2), var(--dark3)) !important;
        color: var(--bright1) !important;
    }

    .dashboard-container {
        max-width: 1100px;
        margin: 2rem auto;
        padding: 2rem;
    }

    /* 1. BAGIAN SELAMAT DATANG BERDIRI SENDIRI */
    .welcome-header {
        text-align: left;
        margin-bottom: 2.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    .welcome-header h1 {
        font-size: 2rem;
        font-weight: 700;
    }
    .welcome-header p {
        font-size: 1.1rem;
        opacity: 0.8;
    }

    /* 2. MEMBUAT LAYOUT UTAMA DUA KOLOM */
    .dashboard-main-content {
        display: grid;
        grid-template-columns: 35% 1fr;
        gap: 2.5rem;
    }

    @media (max-width: 992px) {
        .dashboard-main-content {
            grid-template-columns: 1fr;
        }
    }

    /* KOLOM KIRI: STATISTIK */
    .stats-column {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    /* 3. MEMBUAT KARTU STATISTIK LEBIH KECIL */
    .stat-card {
        padding: 1.25rem;
        border-radius: 12px;
        color: var(--dark4);
    }
    .stat-card .value {
        font-size: 1.8rem;
        font-weight: 700;
    }
    .stat-card .label {
        font-size: 0.85rem;
        font-weight: 500;
    }
    .stat-card.blue { background-color: #7CD9CE; }
    .stat-card.green { background-color: #A3DE83; }
    .stat-card.yellow { background-color: #F8E16C; }

    /* KOLOM KANAN: AKSI DAN DAFTAR KUIS */
    .actions-column {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }
    .action-buttons {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    .action-btn {
        padding: 1rem;
        border-radius: 12px;
        text-align: center;
        text-decoration: none;
        font-size: 1rem;
        font-weight: 700;
    }
    .btn-primary { background-color: #6C63FF; color: white; }
    body.dark-mode .btn-primary { background-color: var(--bright2); color: var(--dark4); }
    .btn-secondary { background-color: var(--dark1); color: white; }
    body.dark-mode .btn-secondary { background-color: var(--dark3); }

    .recent-quizzes h2 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }
    .quiz-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    .quiz-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: rgba(255, 255, 255, 0.6);
        padding: 1rem 1.5rem;
        border-radius: 12px;
    }
    body.dark-mode .quiz-item {
        background-color: rgba(0, 0, 0, 0.2);
    }
    .quiz-item .start-btn {
        background-color: var(--bright2);
        color: var(--dark4);
        padding: 0.5rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 700;
    }
</style>
@endpush

@section('content')
<div class="dashboard-container">

    <section class="welcome-header">
        <h1>Selamat datang, {{ Auth::user()->name }}!</h1>
        <p>Lihat progres dan mulai kuis baru di sini.</p>
    </section>

    <div class="dashboard-main-content">

        <div class="stats-column">
            <div class="stat-card blue">
                <div class="value">{{ $quizzesTaken }}</div>
                <div class="label">Kuis Diikuti</div>
            </div>
            <div class="stat-card green">
                <div class="value">{{ $averageScore }}</div>
                <div class="label">Skor Rata-rata</div>
            </div>
            <div class="stat-card yellow">
                <div class="value">{{ $accuracy }}%</div>
                <div class="label">Akurasi</div>
            </div>
        </div>

        <div class="actions-column">
            <section class="action-buttons">
                <a href="{{ route('user.browse') }}" class="action-btn btn-primary">Mulai Kuis Baru</a>
                <a href="{{ route('leaderboard') }}" class="action-btn btn-secondary">Lihat Leaderboard</a>
            </section>

            <section class="recent-quizzes">
                <h2>Kuis Terbaru</h2>
                <div class="quiz-list">
                    @forelse($recentQuizzes as $quiz)
                        <div class="quiz-item">
                            <span>{{ $quiz->title }}</span>
                            <a href="{{ route('quiz.preview', $quiz->id) }}" class="start-btn">Mulai</a>
                        </div>
                    @empty
                        <div class="quiz-item">
                            <span>Belum ada kuis yang tersedia.</span>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>

    </div>
</div>
@endsection