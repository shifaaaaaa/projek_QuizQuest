<header class="app-header">
    <a class="logo" 
       href="{{ Auth::user()->is_admin ? route('admin.dashboard') : route('dashboard') }}">
        QuizQuest
    </a>
    <nav>
    <span style="color: #7CD9CE; align-self: center;">Halo, {{ Auth::user()->name }}!</span>

    @if (Auth::user()->is_admin)
        <a href="{{ route('admin.quizzes.index') }}">📝 Manage Quiz</a> 
        <a href="{{ url('/setgame') }}">🎮 Set Game Rules </a>
        <a href="{{ url('/manageuser') }}">👥 Manage User</a>   
        @endif
    
    <a href="{{ url('/profile') }}">👤 Profile</a>
    <a href="{{ url('/settings') }}">⚙️ Settings</a>

    <form action="{{ route('logout') }}" method="POST" style="display: inline">
        @csrf
        <a href="{{ route('logout') }}"
        onclick="event.preventDefault(); this.closest('form').submit();"
        style="color: white; text-decoration: none; font-weight: bold; display: flex; align-items: center; gap: 0.3rem">
        🚪 Logout
        </a>
    </form>
    </nav>
</header>
