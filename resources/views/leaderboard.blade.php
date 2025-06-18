@extends('layouts.app')

@section('title', 'Leaderboard - QuizQuest')

@push('styles')
<style>
.leaderboard-container {
    background-color: white;
    color: black;
    margin: 4rem auto;
    padding: 2rem;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    max-width: 700px;
    backdrop-filter: blur(10px);
    transition: background 0.3s, color 0.3s;
}

body.dark-mode .leaderboard-container {
    background-color: rgba(255, 255, 255, 0.05);
    color: white;
}

.leaderboard-title {
    font-size: 2rem;
    font-weight: 700;
    text-align: center;
    margin-bottom: 2rem;
    color: var(--dark4);
    transition: color 0.3s ease;
}

body.dark-mode .leaderboard-title {
    color: var(--bright1);
}

.leaderboard-body {
    max-height: 400px;
    overflow-y: auto;
    display: grid;
    gap: 0.5rem;
    padding-right: 0.3rem;
    background-color: inherit;
}

.leaderboard-header,
.leaderboard-row {
    display: grid;
    grid-template-columns: 50px 1fr 100px; 
    align-items: center;
    padding: 1rem;
    border-radius: 12px;
    font-weight: 600;
    transition: background 0.3s, color 0.3s;
    gap: 1rem;
}

.leaderboard-header {
    background: var(--bright1);
    color: white;
    text-transform: uppercase;
    font-weight: 700;
    position: sticky;
    top: 0;
    z-index: 10;
}

body.dark-mode .leaderboard-header {
    background: var(--dark2);
    color: var(--bright1);
}

.leaderboard-row {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
}

.top1 {
    background: #ffd700; 
    color: #333;
    border: 1px solid #e0c200;
}

.top2 {
    background: #e0e0e0; 
    color: #333;
    border: 1px solid #c0c0c0;
}

.top3 {
    background: #d9a771; 
    color: #fff;
    border: 1px solid #b3895e;
}


body.dark-mode .leaderboard-row {
    background: rgba(255, 255, 255, 0.08);
    border: none;
}


body.dark-mode .top1 {
    background: var(--bright1) !important;
    color: var(--dark4) !important;
}

body.dark-mode .top2 {
    background: var(--bright2) !important;
    color: var(--dark4) !important;
}

body.dark-mode .top3 {
    background: var(--bright3) !important;
    color: var(--dark4) !important;
}

.player-info .username {
    font-size: 0.8rem;
    font-weight: 400;
    color: #6c757d;
    display: block;
    margin-top: 2px;
}
body.dark-mode .player-info .username {
    color: black;
}

.rank, .score {
    text-align: center;
}
.score {
    text-align: right;
    font-weight: 700;
}

.leaderboard-body::-webkit-scrollbar {
    width: 6px;
}

.leaderboard-body::-webkit-scrollbar-thumb {
    background-color: var(--bright2);
    border-radius: 10px;
}

.leaderboard-body {
    scrollbar-width: thin;
    scrollbar-color: var(--bright2) transparent;
}
</style>
@endpush

@section('content')
<section class="leaderboard-container">
    <h2 class="leaderboard-title">🏆 Global Leaderboard</h2>

    <div class="leaderboard-header">
        <span>#</span>
        <span>Player</span>
        <span style="text-align: right;">Score</span>
    </div>

    <div class="leaderboard-body">
        
        @forelse ($leaders as $index => $leader)
            <div class="leaderboard-row {{ $index === 0 ? 'top1' : ($index === 1 ? 'top2' : ($index === 2 ? 'top3' : '') ) }}">
                <span class="rank">{{ $index + 1 }}</span>
                
                <span class="player-info">
                    {{ $index === 0 ? '🥇' : ($index === 1 ? '🥈' : ($index === 2 ? '🥉' : '') ) }}
                    {{ $leader->name }}
                    <span class="username">{{ '@' . $leader->username }}</span>
                </span>
                
                <span class="score">{{ number_format($leader->total_score, 0, ',', '.') }}</span>
            </div>
        @empty
            <div class="leaderboard-row" style="text-align: center; display: block;">
                Belum ada data skor untuk ditampilkan.
            </div>
        @endforelse
    </div>
</section>
@endsection
