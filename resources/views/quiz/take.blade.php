@extends('layouts.app')

@section('title', 'Mengerjakan Quiz - ' . $quiz->title)

@push('styles')
<style>
body {
    background: linear-gradient(to right, var(--bright1), var(--bright2)) !important;
    color: var(--dark4) !important;
    min-height: 100vh;
}

.quiz-container {
    max-width: 900px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.quiz-header {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
    text-align: center;
}

.quiz-timer {
    font-size: 1.5rem;
    font-weight: bold;
    color: var(--dark2);
    margin-bottom: 1rem;
}

.quiz-progress {
    background: #f0f0f0;
    height: 8px;
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 1rem;
}

.quiz-progress-bar {
    background: var(--bright2);
    height: 100%;
    transition: width 0.3s ease;
}

.question-card {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
    display: none;
}

.question-card.active {
    display: block;
}

.question-number {
    color: var(--bright2);
    font-weight: bold;
    margin-bottom: 1rem;
}

.question-text {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    line-height: 1.6;
}

.choice-option {
    display: block;
    width: 100%;
    padding: 1rem;
    margin-bottom: 1rem;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    background: white;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: left;
}

.choice-option:hover {
    border-color: var(--bright2);
    background: #f8f9fa;
}

.choice-option input[type="radio"] {
    margin-right: 1rem;
}

.choice-option.selected {
    border-color: var(--bright2);
    background: #e8f4f8;
}

.navigation-buttons {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 2rem;
}

.btn {
    padding: 0.8rem 2rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
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

.btn-success {
    background: #28a745;
    color: white;
}

.btn-success:hover {
    background: #218838;
}

.question-nav {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-top: 1rem;
}

.question-nav-btn {
    width: 40px;
    height: 40px;
    border: 2px solid #e0e0e0;
    background: white;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    transition: all 0.3s ease;
}

.question-nav-btn.answered {
    background: var(--bright2);
    border-color: var(--bright2);
    color: white;
}

.question-nav-btn.current {
    background: var(--dark2);
    border-color: var(--dark2);
    color: white;
}

/* Dark Mode */
body.dark-mode {
    background: linear-gradient(to right, var(--dark2), var(--dark3)) !important;
    color: var(--bright1) !important;
}

body.dark-mode .quiz-header,
body.dark-mode .question-card {
    background: var(--dark4);
    color: var(--bright1);
}

body.dark-mode .choice-option {
    background: var(--dark3);
    border-color: var(--dark2);
    color: var(--bright1);
}

body.dark-mode .choice-option:hover {
    border-color: var(--bright2);
    background: var(--dark2);
}

body.dark-mode .choice-option.selected {
    border-color: var(--bright2);
    background: var(--dark2);
}
</style>
@endpush

@section('content')
<div class="quiz-container">
    <div class="quiz-header">
        <h1>{{ $quiz->title }}</h1>
        <div class="quiz-timer" id="timer">30:00</div>
        <div class="quiz-progress">
            <div class="quiz-progress-bar" id="progressBar" style="width: 0%"></div>
        </div>
        <div class="question-nav" id="questionNav"></div>
    </div>

    <form id="quizForm" method="POST" action="{{ route('quiz.submit', $quiz->id) }}">
        @csrf
        <input type="hidden" name="time_started" id="timeStarted" value="{{ time() }}">
        
        @foreach($quiz->questions as $index => $question)
        <div class="question-card" data-question="{{ $index + 1 }}" id="question-{{ $index + 1 }}">
            <div class="question-number">Pertanyaan {{ $index + 1 }} dari {{ count($quiz->questions) }}</div>
            <div class="question-text">{{ $question->question }}</div>
            
            @foreach($question->choices as $choice)
            <label class="choice-option" for="choice-{{ $choice->id }}">
                <input type="radio" 
                    name="answers[{{ $question->id }}]" 
                    value="{{ $choice->id }}"
                    id="choice-{{ $choice->id }}"
                    onchange="markAnswered({{ $index + 1 }})">
                <strong>{{ $choice->choice_key }}.</strong> {{ $choice->choice }}
            </label>
            @endforeach
        </div>
        @endforeach

        <div class="navigation-buttons">
            <button type="button" class="btn btn-secondary" id="prevBtn" onclick="changeQuestion(-1)" style="display: none;">
                Sebelumnya
            </button>
            <div>
                <button type="button" class="btn btn-primary" id="nextBtn" onclick="changeQuestion(1)">
                    Selanjutnya
                </button>
                <button type="submit" class="btn btn-success" id="submitBtn" style="display: none;">
                    Selesai
                </button>
            </div>
        </div>
    </form>
</div>

<script>
let currentQuestion = 1;
const totalQuestions = {{ count($quiz->questions) }};
let timeLeft = 30 * 60; // 30 menit dalam detik
let timerInterval;
let answeredQuestions = new Set();

// Inisialisasi
document.addEventListener('DOMContentLoaded', function() {
    showQuestion(1);
    createQuestionNav();
    startTimer();
});

function startTimer() {
    timerInterval = setInterval(function() {
        timeLeft--;
        updateTimerDisplay();
        
        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            alert('Waktu habis! Quiz akan otomatis disubmit.');
            document.getElementById('quizForm').submit();
        }
    }, 1000);
}

function updateTimerDisplay() {
    const minutes = Math.floor(timeLeft / 60);
    const seconds = timeLeft % 60;
    document.getElementById('timer').textContent = 
        `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
}

function createQuestionNav() {
    const nav = document.getElementById('questionNav');
    for (let i = 1; i <= totalQuestions; i++) {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'question-nav-btn';
        btn.textContent = i;
        btn.onclick = () => showQuestion(i);
        nav.appendChild(btn);
    }
    updateQuestionNav();
}

function showQuestion(questionNum) {
    // Sembunyikan semua pertanyaan
    document.querySelectorAll('.question-card').forEach(card => {
        card.classList.remove('active');
    });
    
    // Tampilkan pertanyaan yang dipilih
    document.getElementById(`question-${questionNum}`).classList.add('active');
    currentQuestion = questionNum;
    
    // Update tombol navigasi
    updateNavigationButtons();
    updateQuestionNav();
    updateProgressBar();
}

function changeQuestion(direction) {
    const newQuestion = currentQuestion + direction;
    if (newQuestion >= 1 && newQuestion <= totalQuestions) {
        showQuestion(newQuestion);
    }
}

function updateNavigationButtons() {
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');
    
    prevBtn.style.display = currentQuestion > 1 ? 'block' : 'none';
    
    if (currentQuestion === totalQuestions) {
        nextBtn.style.display = 'none';
        submitBtn.style.display = 'block';
    } else {
        nextBtn.style.display = 'block';
        submitBtn.style.display = 'none';
    }
}

function updateQuestionNav() {
    const navBtns = document.querySelectorAll('.question-nav-btn');
    navBtns.forEach((btn, index) => {
        btn.classList.remove('current');
        if (index + 1 === currentQuestion) {
            btn.classList.add('current');
        }
    });
}

function updateProgressBar() {
    const progress = (answeredQuestions.size / totalQuestions) * 100;
    document.getElementById('progressBar').style.width = progress + '%';
}

function markAnswered(questionNum) {
    answeredQuestions.add(questionNum);
    const navBtn = document.querySelectorAll('.question-nav-btn')[questionNum - 1];
    navBtn.classList.add('answered');
    updateProgressBar();
}

// Konfirmasi sebelum meninggalkan halaman
window.addEventListener('beforeunload', function(e) {
    if (timeLeft > 0) {
        e.preventDefault();
        e.returnValue = '';
    }
});

// Handle radio button selection styling
document.addEventListener('change', function(e) {
    if (e.target.type === 'radio') {
        // Remove selected class from all options in this question
        const questionCard = e.target.closest('.question-card');
        questionCard.querySelectorAll('.choice-option').forEach(option => {
            option.classList.remove('selected');
        });
        
        // Add selected class to chosen option
        e.target.closest('.choice-option').classList.add('selected');
    }
});
</script>
@endsection
