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
      /* Default body style, can be overridden by specific page styles */
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

    header.app-header { /* Renamed to avoid conflict if a page has its own header tag */
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

    footer.app-footer { /* Renamed to avoid conflict */
      background-color: var(--dark4);
      color: white;
      padding: 1rem;
      text-align: center;
      width: 100%;
      font-size: 0.9rem;
      margin-top: auto;
    }
  </style>
  @stack('styles') {{-- For page-specific styles --}}
</head>
<body class="{{ session('darkMode', false) ? 'dark-mode' : '' }}"> {{-- Load dark mode preference from session or default --}}
  <header class="app-header">
    <a class="logo" href="{{ url('/') }}">QuizQuest</a>
    <nav>
      {{-- Add authentication checks here eventually --}}
      {{-- Example: @auth ... @else ... @endauth --}}
      <a href="{{ url('/profile') }}">👤 Profile</a>
      <a href="{{ url('/settings') }}">⚙️ Settings</a>
      <a href="{{ url('/login') }}">Login</a>
      {{-- <a href="{{ url('/admin') }}">👑 Admin</a> --}} {{-- Example link to admin panel --}}
    </nav>
  </header>

  <main>
    @yield('content')
  </main>

  <footer class="app-footer">
    &copy; {{ date('Y') }} QuizQuest. All rights reserved.
  </footer>

  <script>
    // Global dark mode function (if needed, or keep specific to pages)
    function applyDarkModePreference() {
      if (localStorage.getItem('darkMode') === 'true') {
        document.body.classList.add('dark-mode');
      } else {
        document.body.classList.remove('dark-mode');
      }
    }
    // Apply on load
    window.onload = function() {
      applyDarkModePreference();
      // If specific pages have their own onload, they should call this or integrate
      if (typeof pageOnLoad === 'function') {
        pageOnLoad();
      }
    };
  </script>
  @stack('scripts') {{-- For page-specific scripts --}}
</body>
</html>