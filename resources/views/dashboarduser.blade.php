@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<style>
.dashboard-container {
    padding: 2rem;
    max-width: 1200px;
    margin: 2rem auto;
}

.welcome-header {
    margin-bottom: 2.5rem;
    padding-left: 0.5rem;
}

.welcome-header h1 {
    font-weight: 700;
    color: var(--dark3);
    font-size: 2.2rem;
}

.welcome-header p {
    color: var(--dark2);
    font-size: 1.1rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.stat-card {
    background-color: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    display: flex;
    align-items: center;
    gap: 1.5rem;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

.stat-card .icon {
    font-size: 2.5rem;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    flex-shrink: 0;
}

.stat-card .value {
    font-size: 2rem;
    font-weight: bold;
    color: var(--dark3);
}

.stat-card .label {
    color: #6c757d;
    font-size: 0.9rem;
}

.icon-quiz { background-color: #e8f4f8; color: #007bff; }
.icon-avg { background-color: #e8f8eb; color: #28a745; }
.icon-high { background-color: #f8e8f8; color: #6f42c1; }
.icon-correct { background-color: #f8f3e8; color: #fd7e14; }

body.dark-mode .welcome-header h1 {
    color: var(--bright1);
}
body.dark-mode .welcome-header p {
    color: #adb5bd;
}
body.dark-mode .stat-card {
    background-color: var(--dark4);
    box-shadow: none;
}
body.dark-mode .stat-card .value {
    color: white;
}
body.dark-mode .stat-card .label {
    color: #9ab;
}

</style>
@endpush

@section('content')
<div class="dashboard-container">
    <div class="welcome-header">
        <h1>Selamat Datang Kembali, {{ Auth::user()->name }}!</h1>
        <p>Lihat ringkasan progres dan pencapaian kuis Anda di bawah ini.</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="icon icon-quiz">
                <i class="fas fa-list-check"></i>
            </div>
            <div>
                <div class="value">{{ $quizzesTaken }}</div>
                <div class="label">Kuis Selesai</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="icon icon-avg">
                <i class="fas fa-bullseye"></i>
            </div>
            <div>
                <div class="value">{{ $averageScore }}%</div>
                <div class="label">Skor Rata-rata</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="icon icon-high">
                <i class="fas fa-trophy"></i>
            </div>
            <div>
                <div class="value">{{ $highestScore }}%</div>
                <div class="label">Skor Tertinggi</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="icon icon-correct">
                <i class="fas fa-check"></i>
            </div>
            <div>
                <div class="value">{{ $totalCorrectAnswers }}</div>
                <div class="label">Total Jawaban Benar</div>
            </div>
        </div>
    </div>

</div>
@endsection
