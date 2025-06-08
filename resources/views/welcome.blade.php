<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QuizQuest - Challenge Your Mind</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bright1: #7CD9CE;
            --bright2: #5EBEBD;
            --bright3: #4499A3;
            --dark1: #2E7588;
            --dark2: #1D536C;
            --dark3: #0F3551;
            --dark4: #061C36;
            --gradient-primary: linear-gradient(135deg, var(--bright1), var(--bright3));
            --gradient-dark: linear-gradient(135deg, var(--dark3), var(--dark4));
            --shadow-light: 0 10px 25px rgba(0, 0, 0, 0.1);
            --shadow-medium: 0 15px 35px rgba(0, 0, 0, 0.15);
            --border-radius: 16px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: var(--gradient-primary);
            color: var(--dark4);
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        body.dark-mode {
            background: var(--gradient-dark);
            color: white;
        }

        .welcome-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: var(--shadow-light);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        body.dark-mode .welcome-header {
            background: rgba(6, 28, 54, 0.95);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo {
            font-size: 2rem;
            font-weight: 700;
            font-family: 'Quicksand', sans-serif;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .header-controls {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .dark-mode-toggle {
            background: var(--bright3);
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-light);
        }

        .dark-mode-toggle:hover {
            background: var(--dark2);
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
        }

        body.dark-mode .dark-mode-toggle {
            background: var(--bright2);
            color: var(--dark4);
        }

        .auth-buttons {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .auth-buttons a {
            color: var(--dark3);
            text-decoration: none;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius);
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(5px);
        }

        .auth-buttons a:hover {
            background: var(--bright1);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
        }

        body.dark-mode .auth-buttons a {
            color: var(--bright1);
            background: rgba(255, 255, 255, 0.1);
        }

        body.dark-mode .auth-buttons a:hover {
            background: var(--bright3);
            color: white;
        }

        .hero-section {
            text-align: center;
            padding: 6rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .hero-title {
            font-size: 4.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, var(--dark4), var(--dark2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
        }

        body.dark-mode .hero-title {
            background: linear-gradient(135deg, var(--bright1), var(--bright3));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            color: var(--dark2);
            margin-bottom: 3rem;
            font-weight: 300;
            line-height: 1.6;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        body.dark-mode .hero-subtitle {
            color: var(--bright2);
        }

        .cta-buttons {
            display: flex;
            gap: 2rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 5rem;
        }

        .cta-button {
            padding: 1.5rem 3rem;
            border: none;
            border-radius: var(--border-radius);
            font-size: 1.2rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: var(--shadow-light);
        }

        .cta-primary {
            background: var(--gradient-primary);
            color: white;
        }

        .cta-primary:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-medium);
        }

        .cta-secondary {
            background: rgba(255, 255, 255, 0.9);
            color: var(--dark3);
            backdrop-filter: blur(10px);
        }

        .cta-secondary:hover {
            background: white;
            transform: translateY(-3px);
            box-shadow: var(--shadow-medium);
        }

        body.dark-mode .cta-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: var(--bright1);
        }

        body.dark-mode .cta-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .features-preview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }

        .feature-preview {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: var(--border-radius);
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-light);
        }

        .feature-preview:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-medium);
        }

        body.dark-mode .feature-preview {
            background: rgba(255, 255, 255, 0.1);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
        }

        .feature-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark3);
        }

        body.dark-mode .feature-title {
            color: var(--bright1);
        }

        .feature-desc {
            color: var(--dark2);
            font-size: 0.9rem;
        }

        body.dark-mode .feature-desc {
            color: var(--bright2);
        }

        .footer {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            color: var(--dark3);
            padding: 2rem;
            text-align: center;
            font-size: 0.9rem;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        body.dark-mode .footer {
            background: rgba(6, 28, 54, 0.9);
            color: var(--bright2);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .welcome-header {
                padding: 1rem;
                flex-direction: column;
                gap: 1rem;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.2rem;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }

            .cta-button {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }

            .hero-section {
                padding: 3rem 1rem;
            }

            .auth-buttons {
                flex-wrap: wrap;
                justify-content: center;
                gap: 0.5rem;
            }

            .auth-buttons a {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }

            .logo {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <header class="welcome-header">
        <a class="logo" href="{{ url('/') }}">QuizQuest</a>
        
        <div class="header-controls">
            <button class="dark-mode-toggle" onclick="toggleDarkMode()" title="Toggle Dark Mode">
                <span class="dark-icon">🌙</span>
                <span class="light-icon" style="display: none;">☀️</span>
            </button>
            
            <div class="auth-buttons">
                <a href="{{ route('login') }}">🔐 Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">📝 Sign Up</a>
                @endif
            </div>
        </div>
    </header>

    <main>
        <div class="hero-section">
            <h1 class="hero-title">Welcome to QuizQuest</h1>
            <p class="hero-subtitle">
    The ultimate destination for interactive quizzes, brain challenges, 
    and knowledge competitions. Join thousands of players testing their skills daily!
</p>
            
            <div class="cta-buttons">
                <a href="{{ route('login') }}" class="cta-button cta-primary">
                    🚀 Start Your Journey
                </a>
                <a href="{{ route('register') }}" class="cta-button cta-secondary">
                    📝 Create Account
                </a>
            </div>

            <div class="features-preview">
    <div class="feature-preview">
        <span class="feature-icon">🧠</span>
        <h3 class="feature-title">Smart Quizzes</h3>
        <p class="feature-desc">AI-powered adaptive quizzes that match your skill level</p>
    </div>
    
    <div class="feature-preview">
        <span class="feature-icon">🏆</span>
        <h3 class="feature-title">Competitions</h3>
        <p class="feature-desc">Real-time battles and global leaderboards</p>
    </div>
    
    <div class="feature-preview">
        <span class="feature-icon">🎯</span>
        <h3 class="feature-title">Multiple Categories</h3>
        <p class="feature-desc">Thousands of quizzes across various topics and difficulty levels</p>
    </div>
    
    <div class="feature-preview">
        <span class="feature-icon">⚡</span>
        <h3 class="feature-title">Instant Results</h3>
        <p class="feature-desc">Get immediate feedback and explanations for every question</p>
    </div>
</div>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} QuizQuest. Crafted with ❤️ for quiz enthusiasts worldwide.</p>
    </footer>

    <script>
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            const isDark = document.body.classList.contains('dark-mode');
            localStorage.setItem('darkMode', isDark);
            
            // Toggle icons
            const darkIcon = document.querySelector('.dark-icon');
            const lightIcon = document.querySelector('.light-icon');
            
            if (isDark) {
                darkIcon.style.display = 'none';
                lightIcon.style.display = 'inline';
            } else {
                darkIcon.style.display = 'inline';
                lightIcon.style.display = 'none';
            }
        }

        function applyDarkModePreference() {
            const isDark = localStorage.getItem('darkMode') === 'true';
            if (isDark) {
                document.body.classList.add('dark-mode');
            }
            
            // Set correct icon
            const darkIcon = document.querySelector('.dark-icon');
            const lightIcon = document.querySelector('.light-icon');
            
            if (isDark) {
                darkIcon.style.display = 'none';
                lightIcon.style.display = 'inline';
            } else {
                darkIcon.style.display = 'inline';
                lightIcon.style.display = 'none';
            }
        }

        window.onload = function() {
            applyDarkModePreference();
        };
    </script>
</body>
</html>
