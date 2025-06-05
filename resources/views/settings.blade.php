@extends('layouts.app')

@section('title', 'Account Settings - QuizQuest')

@push('styles')
<style>
   .settings-page-header { 
    background-color: var(--dark4);
    color: white;
    width: 100%;
    padding: 1.2rem;
    text-align: center;
    font-size: 1.5rem;
    font-weight: bold;
  }

  .settings-container {
    background-color: white;
    color: black; 
    margin: 2rem auto;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    width: 90%;
    max-width: 600px;
    transition: background 0.3s, color 0.3s;
  }

  body.dark-mode .settings-container {
    background-color: var(--dark3); 
    color: white;
  }

  .settings-header {
    text-align: center;
    margin-bottom: 2rem;
  }

  .settings-header h2 { 
    color: var(--dark3);
  }
  body.dark-mode .settings-header h2 {
    color: var(--bright1);
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
  body.dark-mode .form-group label {
    color: var(--bright2);
  }

  .form-group input[type="text"],
  .form-group input[type="email"],
  .form-group input[type="password"] {
    width: 100%;
    padding: 0.7rem;
    border: 1px solid var(--bright3);
    border-radius: 8px;
    outline: none;
    background-color: white; 
    color: var(--dark4); 
  }
  body.dark-mode .form-group input[type="text"],
  body.dark-mode .form-group input[type="email"],
  body.dark-mode .form-group input[type="password"] {
    background-color: var(--dark1);
    border-color: var(--dark3);
    color: white;
  }

  .form-group button {
    background-color: var(--dark1);
    color: white;
    padding: 0.7rem 1.5rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  .form-group button:hover {
    background-color: var(--dark2);
  }
  body.dark-mode .form-group button {
     background-color: var(--bright2);
     color: var(--dark4);
  }
  body.dark-mode .form-group button:hover {
     background-color: var(--bright1);
  }


  .toggle-mode {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-top: 1.5rem;
  }

  .toggle-mode input[type="checkbox"] {
    width: 20px;
    height: 20px;
  }
</style>
@endpush

@section('content')
{{-- placeholder buat header dari layout.app buat settings page, 
    kalo ga mau pake bisa uncomment bagian .settings-page-header di atas sama di sini yaww:

<header class="settings-page-header">
  Account Settings - QuizQuest
</header>
--}}

<div class="settings-container">
  <div class="settings-header">
    <h2>Account Settings</h2> 
  </div>
  <form action="{{ url('/settings/update') }}" method="POST">
    @csrf
    @method('PATCH')

    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" value="{{ old('username', $user->username ?? 'johndoe123') }}">
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="{{ old('email', $user->email ?? 'johndoe@example.com') }}">
    </div>
    <div class="form-group">
      <label for="password">New Password (leave blank if no change)</label>
      <input type="password" id="password" name="password">
    </div>
     <div class="form-group">
      <label for="password_confirmation">Confirm New Password</label>
      <input type="password" id="password_confirmation" name="password_confirmation">
    </div>

    <div class="form-group toggle-mode">
      <label for="darkmode">Enable Dark Mode</label>
      <input type="checkbox" id="darkmode" onchange="toggleSettingsDarkMode(this)">
    </div>

    <div class="form-group">
      <button type="submit">Update Settings</button>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
  function toggleSettingsDarkMode(checkbox) {
    document.body.classList.toggle("dark-mode", checkbox.checked);
    localStorage.setItem("darkMode", checkbox.checked);
  }

  function pageOnLoad() {
    const isDark = localStorage.getItem("darkMode") === "true";
    const darkModeCheckbox = document.getElementById("darkmode");
    if (darkModeCheckbox) {
        darkModeCheckbox.checked = isDark;
    }
  }
</script>
@endpush