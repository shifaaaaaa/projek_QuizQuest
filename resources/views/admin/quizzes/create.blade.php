@extends('layouts.app') {{-- Keep extending layouts.app --}}

@section('title', 'Create Quiz - Admin QuizQuest')

@push('styles')
<style>
body {
    background: linear-gradient(to right, var(--bright1), var(--bright2)) !important;
    color: var(--dark4) !important;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    box-sizing: border-box;
    align-items: center;
    padding: 0;
    margin: 0;
}

.create-quiz-title { 
    text-align: center;
    margin-bottom: 2rem;
    margin-top: 2rem;
    color: var(--dark3);
}

.quiz-form {
    background-color: white;
    padding: 2rem;
    max-width: 1000px;
    min-width: 600px;
    width: 100%;
    margin: 0 auto;
    border-radius: 12px;
    box-shadow: 0 10px 18px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    font-weight: bold;
    display: block;
    margin-bottom: 0.5rem;
    color: var(--dark2);
}

.form-group input[type="text"],
.form-group textarea,
.form-group select {
    width: 100%;
    padding: 0.8rem;
    border-radius: 8px;
    border: 1px solid var(--bright3);
    background-color: white;
    color: var(--dark4);
    box-sizing: border-box;
    word-wrap: break-word;
    overflow-wrap: break-word;
    white-space: normal;
    margin-bottom: 0.5rem;
}

.form-group button {
    background-color: var(--dark2);
    color: white;
    padding: 0.8rem 1.6rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s ease;
}

.form-group button:hover {
    background-color: var(--dark3);
}

.form-group button[type="button"] {
    background-color: var(--bright3);
    color: var(--dark4);
}

.form-group button[type="button"]:hover {
    background-color: var(--bright2);
}

.question-section {
    margin-top: 2rem;
    max-height: 200px;
    overflow-y: auto;
    padding-right: 0.3rem;
    scrollbar-width: thin;
    scrollbar-color: var(--bright2) transparent;
    border: 1px solid var(--bright3);
    border-radius: 8px;
    background-color: #f4fefe;
    width: 100%;
    box-sizing: border-box;
}

.question-section::-webkit-scrollbar {
    width: 6px;
}

.question-section::-webkit-scrollbar-thumb {
    background-color: var(--bright2);
    border-radius: 10px;
}

.question-box {
    width: 100%;
    flex-shrink: 0;
    padding: 1rem;
    margin-bottom: 1.2rem;
    border-bottom: 1px solid var(--bright3);
    color: var(--dark2);
    box-sizing: border-box;
}

.question-box:last-child {
    border-bottom: none;
}

.question-box label {
    color: var(--dark2);
    display: block;
    margin-bottom: 0.5rem;
    font-weight: bold;
}

.question-textarea {
    width: 100%;
    min-height: 50px;
    max-height: 100px;
    resize: vertical;
    padding: 0.6rem;
    border-radius: 8px;
    border: 1px solid var(--bright3);
    background-color: white;
    color: var(--dark4);
    box-sizing: border-box;
    word-wrap: break-word;
    overflow-wrap: break-word;
    white-space: normal;
    margin-bottom: 0.5rem;
}

.options-textarea {
    width: 100%;
    min-height: 30px;
    max-height: 60px;
    resize: vertical;
    padding: 0.6rem;
    border-radius: 8px;
    border: 1px solid var(--bright3);
    background-color: white;
    color: var(--dark4);
    box-sizing: border-box;
    word-wrap: break-word;
    overflow-wrap: break-word;
    white-space: normal;
    margin-bottom: 0.5rem;
}

/* Dark Mode Styles */
body.dark-mode {
    background: linear-gradient(to right, var(--dark2), var(--dark3)) !important;
    color: var(--bright1) !important;
}

body.dark-mode .create-quiz-title {
    color: var(--bright1);
    margin-top: 2rem;
}

body.dark-mode .quiz-form {
    background-color: var(--dark4);
    color: var(--bright1);
    box-shadow: 0 10px 18px rgba(0, 0, 0, 0.5);
}

body.dark-mode .form-group label {
    color: var(--bright1);
}

body.dark-mode .form-group input[type="text"],
body.dark-mode .form-group textarea,
body.dark-mode .form-group select {
    background: var(--dark3);
    color: var(--bright1);
    border: 1px solid var(--dark2);
}

body.dark-mode .question-section {
    background: var(--dark3);
    color: var(--bright1);
    border: 1px solid var(--dark2);
}

body.dark-mode .question-box label {
    color: var(--bright1);
}

body.dark-mode .question-textarea,
body.dark-mode .options-textarea {
    background: var(--dark3);
    color: var(--bright1);
    border: 1px solid var(--dark2);
}

body.dark-mode .form-group button {
    background: var(--dark2);
    color: var(--bright1);
}

body.dark-mode .form-group button:hover {
    background: var(--dark1);
}

.form-group input[type="number"] {
    width: 100%;
    padding: 0.8rem;
    border-radius: 8px;
    border: 1px solid var(--bright3);
    background-color: white;
    color: var(--dark4);
    box-sizing: border-box;
    margin-bottom: 0.5rem;
}

body.dark-mode .form-group input[type="number"] {
    background: var(--dark3);
    color: var(--bright1);
    border: 1px solid var(--dark2);
}


</style>
@endpush

@section('content')
<h1 class="create-quiz-title">Create New Quiz</h1>
<div class="quiz-form">
  <form action="{{ url('/admin/quizzes') }}" method="POST">
    @csrf
    <div class="form-group">
      <label for="title">Quiz Title</label>
      <input type="text" id="title" name="title" placeholder="Enter quiz title" value="{{ old('title') }}">
    </div>

    <div class="form-group">
      <label for="description">Quiz Description</label>
      <textarea id="description" name="description" rows="3" placeholder="Enter quiz description">{{ old('description') }}</textarea>
    </div>

    <div class="form-group">
      <label for="min_level">Minimum Level</label>
      <input type="number" name="min_level" id="min_level" value="{{ old('min_level', $quiz->min_level ?? 1) }}" min="1">
    </div>

    <div class="question-section" id="questions-container">
      <div class="question-box">
        <label for="questions[0][question]">Question 1</label>
        <textarea name="questions[0][question]" placeholder="Enter your question" class="question-textarea">{{ old('questions.0.question') }}</textarea>    

        <label>A</label>
        <textarea name="questions[0][options][A]" placeholder="Option A" class="options-textarea">{{ old('questions.0.options.A') }}</textarea>
        <label>B</label>
        <textarea name="questions[0][options][B]" placeholder="Option B" class="options-textarea">{{ old('questions.0.options.B') }}</textarea>
        <label>C</label>
        <textarea name="questions[0][options][C]" placeholder="Option C" class="options-textarea">{{ old('questions.0.options.C') }}</textarea>
        <label>D</label>
        <textarea name="questions[0][options][D]" placeholder="Option D" class="options-textarea">{{ old('questions.0.options.D') }}</textarea>
        
        <label for="questions[0][correct]">Correct Answer</label>
        <select name="questions[0][correct]">
          <option value="">Select</option>
          <option value="A">A</option>
          <option value="B">B</option>
          <option value="C">C</option>
          <option value="D">D</option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <button type="button" onclick="addQuestion()"
      style="margin-top: 20px;"
      >+ Add Question</button>
    </div>

    <div class="form-group" style="text-align: center">
      <button type="submit">Save Quiz</button>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
  let questionCount = 1;

  function addQuestion() {
    const container = document.getElementById("questions-container");

    const div = document.createElement("div");
    div.classList.add("question-box");

    div.innerHTML = `
      <label for="questions[${questionCount}][question]">Question ${questionCount + 1}</label>
      <textarea name="questions[${questionCount}][question]" placeholder="Enter your question" class="question-textarea"></textarea>

      <label>A</label>
      <textarea name="questions[${questionCount}][options][A]" placeholder="Option A" class="options-textarea"></textarea>
      <label>B</label>
      <textarea name="questions[${questionCount}][options][B]" placeholder="Option B" class="options-textarea"></textarea>
      <label>C</label>
      <textarea name="questions[${questionCount}][options][C]" placeholder="Option C" class="options-textarea"></textarea>
      <label>D</label>
      <textarea name="questions[${questionCount}][options][D]" placeholder="Option D" class="options-textarea"></textarea>
      
      <label for="questions[${questionCount}][correct]">Correct Answer</label>
      <select name="questions[${questionCount}][correct]">
        <option value="">Select</option>
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
      </select>

      <button type="button" class="remove-question" onclick="removeQuestion(this)">Remove</button>
    `;
    container.appendChild(div);
    questionCount++;
  }

  function removeQuestion(el) {
    el.parentElement.remove();
    reindexQuestions();
  }

  function reindexQuestions(){
    const questions = document.querySelectorAll('.question-box');
    questionCount = questions.length;

    questions.forEach((questionBox, index) => {
      questionBox.querySelector('label[for^="questions"]').innerHTML = `Question ${index + 1}`;

      // Update all name attributes to match the new index
      questionBox.querySelectorAll('textarea, select').forEach(el => {
        const name = el.name;
        el.name = name.replace(/\[(\d+)\]/, '[' + index + ']');
      });
    });
  }
</script>
@endpush
