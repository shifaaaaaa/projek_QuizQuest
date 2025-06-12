<header class="app-header">
    {{-- Logika kondisional untuk link logo --}}
    @if (Auth::user()->is_admin)
        <a class="logo" href="{{ route('admin.dashboard') }}">QuizQuest</a>
    @else
        <a class="logo" href="{{ route('dashboard') }}">QuizQuest</a>
    @endif

    <nav>
        <span style="color: #7CD9CE; align-self: center;">Halo, {{ Auth::user()->name }}!</span>

        @if (Auth::user()->is_admin)
            {{-- Admin --}}
            <a href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
            <a href="{{ route('admin.quizzes.index') }}">Kelola Kuis</a>
        @else
            {{-- User --}}
            {{-- <a href="{{ route('dashboard') }}">🏠 Dashboard</a> --}}
            <a href="{{ url('/leaderboard') }}">🏆 Leaderboard</a>
            <a href="{{ url('/profile') }}">👤 Profile</a>
            <a href="{{ url('/settings') }}">⚙️ Settings</a>
        @endif

        {{-- Logout link --}}
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); this.closest('form').submit();"
               style="color: white; text-decoration: none; font-weight: bold; display: flex; align-items: center; gap: 0.3rem;">
                🚪 Logout
            </a>
        </form>
    </nav>
</header>