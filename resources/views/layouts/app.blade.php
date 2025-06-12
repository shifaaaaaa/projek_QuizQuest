<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'QuizQuest')</title>
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --bright1: #7CD9CE;
      --bright2: #5EBEBD;
      --bright3: #4499A3;
      --dark1: #2E7588;
      --dark2: #1D536C;
      --dark3: #0F3551;
      --dark4: #061C36;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Quicksand', sans-serif;
    }

    body {
      background: linear-gradient(to right, var(--bright1), var(--bright3));
      color: #000;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      transition: background 0.5s, color 0.5s;
    }

    body.dark-mode {
      background: linear-gradient(to right, var(--dark3), var(--dark4));
      color: white;
    }

    /* Pindahkan gaya header dan nav ke sini atau ke file CSS terpisah */
    header.app-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 2rem;
      background-color: var(--dark4);
      color: white;
      width: 100%;
    }

    .logo {
      font-size: 1.8rem;
      font-weight: bold;
      cursor: pointer;
      text-decoration: none;
      color: white;
    }

    nav {
      display: flex;
      gap: 1rem;
    }

    nav a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      display: flex;
      align-items: center;
      gap: 0.3rem;
    }

    footer.app-footer {
      background-color: var(--dark4);
      color: white;
      padding: 1rem;
      text-align: center;
      width: 100%;
      font-size: 0.9rem;
      margin-top: auto;
    }
  </style>
  @stack('styles')
</head>
<<<<<<< HEAD
<body class="{{ session('darkMode', false) ? 'dark-mode' : '' }}">

  {{-- Logika untuk menyertakan partial header yang sesuai --}}
  @guest
    @include('partials.header-guest')
  @endguest
=======
<body class="{{ session('darkMode', false) ? 'dark-mode' : '' }}"> {{-- Load dark mode preference from session or default --}}
  <header class="app-header">
    <a class="logo" href="{{ url('/') }}">QuizQuest</a>
    <nav>

      

      @guest
        {{-- Tautan ini hanya akan muncul jika pengguna BELUM login --}}
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('signup') }}">Signup</a>
      @endguest

      

      @auth 
        {{-- Tautan ini hanya akan muncul jika pengguna SUDAH login --}}
        <span style="color: #7CD9CE; align-self: center;">Halo, {{ Auth::user()->name }}!</span>
        <a href="{{ url('/leaderboard') }}">🏆 Leaderboard</a> 
        <a href="{{ url('/home') }}">🏠 Home</a> 
        <a href="{{ url('/profile') }}">👤 Profile</a>
        <a href="{{ url('/settings') }}">⚙️ Settings</a>
>>>>>>> a63e3e1dde32ede99d54aba0264885e21dd83138

  @auth
    @include('partials.header-authenticated')
  @endauth

  <main>
    @yield('content')
  </main>

  <footer class="app-footer">
    &copy; {{ date('Y') }} QuizQuest. All rights reserved.
  </footer>

  <script>
    function applyDarkModePreference() {
      if (localStorage.getItem('darkMode') === 'true') {
        document.body.classList.add('dark-mode');
      } else {
        document.body.classList.remove('dark-mode');
      }
    }
    window.onload = function() {
      applyDarkModePreference();
      if (typeof pageOnLoad === 'function') {
        pageOnLoad();
      }
    };
  </script>
  @stack('scripts')
</body>
</html>