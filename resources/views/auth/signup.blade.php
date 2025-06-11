{{-- File: resources/views/auth/signup.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup - QuizQuest</title> 
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
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Quicksand', sans-serif; }
    body {
      background: linear-gradient(135deg, var(--bright2), var(--bright1));
      min-height: 100vh; display: flex; flex-direction: column;
      align-items: center; justify-content: center;
    }
    .signup-container {
      background-color: white; padding: 3rem; border-radius: 12px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); max-width: 400px; width: 90%;
    }
    .signup-container h2 {
      margin-bottom: 1.5rem; color: var(--dark4); text-align: center;
    }
    .form-group { margin-bottom: 1.2rem; }
    .form-group label { display: block; margin-bottom: 0.5rem; color: var(--dark2); }
    .form-group input { width: 100%; padding: 0.75rem; border: 1px solid var(--dark1); border-radius: 8px; }
    .btn {
      width: 100%; padding: 0.9rem; background-color: var(--dark3); color: white;
      font-weight: bold; border: none; border-radius: 8px; cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .btn:hover { background-color: var(--dark1); }
    .link { margin-top: 1rem; text-align: center; }
    .link a { color: var(--dark2); text-decoration: none; }
    .link a:hover { text-decoration: underline; }
    .error-message { color: red; font-size: 0.9em; margin-top: 0.2em; }
  </style>
</head>
<body>
  <div class="signup-container">
    <h2>Create Your QuizQuest Account</h2>
    <form action="{{ url('/signup') }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="{{ old('username') }}" required>
        @error('username') <p class="error-message">{{ $message }}</p> @enderror
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        @error('email') <p class="error-message">{{ $message }}</p> @enderror
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
        @error('password') <p class="error-message">{{ $message }}</p> @enderror
      </div>
      <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
      </div>
      <button type="submit" class="btn">Sign Up</button>
    </form>
    <div class="link">
      <p>Already have an account? <a href="{{ url('/login') }}">Login</a></p>
    </div>

    @if (session('success'))
      <div style="color: green; margin-bottom: 1rem; text-align: center;">{{ session('success') }}</div>
    @endif
    
    @if ($errors->any())
        <div style="padding: 1rem; margin-bottom: 1rem; border: 1px solid #f5c6cb; border-radius: .25rem; color: #721c24; background-color: #f8d7da;">
            <strong>Whoops! Ada yang salah dengan input Anda.</strong><br><br>
            <ul style="margin-bottom: 0; padding-left: 1.2rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  </div>
</body>
</html>