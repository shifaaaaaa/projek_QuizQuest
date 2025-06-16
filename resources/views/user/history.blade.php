@extends('layouts.app')

@section('title', 'Riwayat Quiz')

@push('styles')
<style>
body {
    background: linear-gradient(to right, var(--bright1), var(--bright2)) !important;
    color: var(--dark4) !important;
    min-height: 100vh;
}

.history-container {
    max-width: 1000px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.history-header {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
    text-align: center;
}

.history-table {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th,
.table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid #eee;
}

.table th {
    background: #f8f9fa;
    font-weight: bold;
    color: var(--dark2);
}

.table tr:hover {
    background: #f8f9fa;
}

.score-badge {
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-weight: bold;
    color: white;
    font-size: 0.9rem;
}

.score-excellent { background: #28a745; }
.score-good { background: #17a2b8; }
.score-average { background: #ffc107; color: #333; }
.score-poor { background: #dc3545; }

.btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    font-size: 0.9rem;
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

.empty-state {
    text-align: center;
    padding: 3rem;
    color: #666;
}

.pagination {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}

/* Dark Mode */
body.dark-mode {
    background: linear-gradient(to right, var(--dark2), var(--dark3)) !important;
    color: var(--bright1) !important;
}

body.dark-mode .history-header,
body.dark-mode .history-table {
    background: var(--dark4);
    color: var(--bright1);
}

body.dark-mode .table th {
    background: var(--dark3);
    color: var(--bright1);
}

body.dark-mode .table tr:hover {
    background: var(--dark3);
}
</style>
@endpush

@section('content')
<div class="history-container">
    <div class="history-header">
        <h1>Riwayat Quiz</h1>
        <p>Berikut adalah daftar quiz yang telah Anda kerjakan</p>
    </div>

    @if($results->count() > 0)
    <div class="history-table">
        <table class="table">
            <thead>
                <tr>
                    <th>Quiz</th>
                    <th>Skor</th>
                    <th>Benar/Total</th>
                    <th>Waktu</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                <tr>
                    <td>
                        <strong>{{ $result->quiz->title }}</strong>
                        <br>
                        <small style="color: #666;">{{ Str::limit($result->quiz->description, 50) }}</small>
                    </td>
                    <td>
                        @php
                            $scoreClass = 'score-poor';
                            if ($result->score >= 80) $scoreClass = 'score-excellent';
                            elseif ($result->score >= 70) $scoreClass = 'score-good';
                            elseif ($result->score >= 60) $scoreClass = 'score-average';
                        @endphp
                        <span class="score-badge {{ $scoreClass }}">{{ $result->score }}%</span>
                    </td>
                    <td>{{ $result->correct_answers }}/{{ $result->total_questions }}</td>
                    <td>{{ gmdate('i:s', $result->time_taken) }}</td>
                    <td>{{ $result->completed_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('quiz.result', $result->id) }}" class="btn btn-primary">
                            Lihat Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $results->links() }}
    @else
    <div class="history-table">
        <div class="empty-state">
            <h3>Belum Ada Riwayat</h3>
            <p>Anda belum mengerjakan quiz apapun.</p>
            <a href="{{ route('user.browse') }}" class="btn btn-primary">Mulai Quiz</a>
        </div>
    </div>
    @endif
</div>
@endsection
