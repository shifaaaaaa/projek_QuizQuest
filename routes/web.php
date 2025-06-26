<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Quiz;
use App\Models\QuizResult;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController; 
use App\Http\Controllers\Admin\QuestionController;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    Log::info('Login attempt:', $request->all());

    $request->validate([
        'login' => 'required|string',
        'password' => 'required|string',
    ]);

    $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    $credentials = [
        $loginField => $request->login,
        'password' => $request->password,
    ];

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();

        return Auth::user()->is_admin
            ? redirect()->intended(route('admin.dashboard'))
            : redirect()->intended(route('dashboard'));
    }

    return back()->withErrors([
        'login' => 'Username/email atau password salah.',
    ])->onlyInput('login');
});

Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup');

Route::post('/signup', function (Request $request) {
    Log::info('Signup attempt:', $request->all());

    $validated = $request->validate([
        'username' => 'required|string|max:255|unique:users,username',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
    ]);

    try {
        $user = User::create([
            'name' => $validated['username'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => false,
        ]);

        Auth::login($user);
        return redirect('/dashboard')->with('success', 'Registrasi berhasil! Selamat datang!');
    } catch (\Exception $e) {
        Log::error('Signup error: ' . $e->getMessage());
        return back()->withInput()->withErrors(['error_signup' => 'Terjadi kesalahan saat mendaftar.']);
    }
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

/*
|--------------------------------------------------------------------------
| User Routes (Auth Required)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        $user = Auth::user();
        
        $results = QuizResult::where('user_id', $user->id)->get();
        
        $quizzesTaken = $results->count();
        $averageScore = $results->avg('score');
        $totalScore = $results->sum('score');

        $totalCorrectAnswers = $results->sum('correct_answers');
        $totalQuestionsAnswered = $results->sum('total_questions');

        $accuracy = $totalQuestionsAnswered > 0 ? ($totalCorrectAnswers / $totalQuestionsAnswered) * 100 : 0;
        $recentQuizzes = Quiz::latest()->take(8)->get();

        return view('dashboarduser', [
            'quizzesTaken' => $quizzesTaken,
            'averageScore' => round($averageScore, 2),
            'totalScore' => $totalScore,
            'accuracy' => round($accuracy),
            'recentQuizzes' => $recentQuizzes,
        ]);
    })->name('dashboard');

    Route::get('/profile', function () {
        return view('profile', ['user' => Auth::user()]);
    })->name('profile');

    Route::get('/settings', function () {
        return view('settings', ['user' => Auth::user()]);
    })->name('settings');

    Route::patch('/settings/update', function (Request $request) {
        $user = Auth::user();

        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->username = $validated['username'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('settings')->with('success', 'Pengaturan berhasil diperbarui!');
    })->name('settings.update');

    Route::get('/leaderboard', function () {
        $leaders = User::select(
            'users.id', 
            'users.name', 
            'users.username', 
            DB::raw('SUM(scores.max_score) as total_score')
        )
        ->join(DB::raw('(SELECT user_id, quiz_id, MAX(score) as max_score FROM quiz_results GROUP BY user_id, quiz_id) as scores'), function($join) {
            $join->on('users.id', '=', 'scores.user_id');
        })
        ->groupBy('users.id', 'users.name', 'users.username')
        ->orderBy('total_score', 'desc')
        ->take(10) 
        ->get();

        return view('leaderboard', ['leaders' => $leaders]);
    })->name('leaderboard');

    // Quiz user routes
    Route::get('/browse', [QuizController::class, 'index'])->name('user.browse');
    Route::get('/quiz/{id}/preview', [QuizController::class, 'preview'])->name('quiz.preview');
    Route::get('/quizzes/{quiz}/start', [QuizController::class, 'start'])->name('quiz.start');
    Route::post('/quiz/{id}/submit', [QuizController::class, 'submit'])->name('quiz.submit');
    Route::get('/quiz/result/{id}', [QuizController::class, 'result'])->name('quiz.result');
    Route::get('/history', [QuizController::class, 'history'])->name('user.history');
});


/*
|--------------------------------------------------------------------------
| Admin Routes (Auth + Admin Middleware)
|--------------------------------------------------------------------------
*/


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/rules', function() {
        return "Halaman 'Set Game Rules' berhasil diakses!";
    })->name('rules.index');

    Route::resource('quizzes', QuizController::class)->except(['show']);
    Route::resource('users', UserController::class)->except(['create', 'store', 'show']);
    Route::get('rules', [SettingController::class, 'index'])->name('rules.index');
    Route::post('rules', [SettingController::class, 'store'])->name('rules.store');
    Route::post('/quizzes/{quiz}/questions', [QuestionController::class, 'store'])->name('questions.store');
});