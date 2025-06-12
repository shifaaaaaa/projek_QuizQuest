<header class="app-header">
<a class="logo" href="{{ url('/dashboard') }}">QuizQuest</a>
    <nav>
    <span style="color: #7CD9CE; align-self: center;">Halo, {{ Auth::user()->name }}!</span>
    <a href="{{ url('/leaderboard') }}">🏆 Leaderboard</a> 
    <a href="{{ url('/profile') }}">👤 Profile</a>
    <a href="{{ url('/settings') }}">⚙️ Settings</a>

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