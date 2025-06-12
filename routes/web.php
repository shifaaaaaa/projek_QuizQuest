
<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Public Routes (Bisa diakses semua orang)
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
        'password' => $request->password
    ];

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();

        return Auth::user()->is_admin
            ? redirect()->intended(route('admin.dashboard'))
            : redirect()->intended(route('home'));
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
        return redirect('/')->with('success', 'Registrasi berhasil! Selamat datang!');
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
| User Routes (Harus login)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
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

    Route::get('/dashboard', function () {
    return view('dashboarduser'); // Mengarah ke dashboarduser.blade.php
    })->middleware('auth')->name('dashboard');

    Route::get('/leaderboard', function () {
    $leaders = collect([
        (object)['name' => 'Layla', 'score' => 900],
        (object)['name' => 'Nara', 'score' => 9500],
        (object)['name' => 'Zaki', 'score' => 9400],
        (object)['name' => 'Rendi', 'score' => 9200],
        (object)['name' => 'Maya', 'score' => 9100],
        (object)['name' => 'Alice', 'score' => 1000],
        (object)['name' => 'Bob', 'score' => 950],
        (object)['name' => 'Charlie', 'score' => 900],
        (object)['name' => 'Diana', 'score' => 870],
        (object)['name' => 'Ethan', 'score' => 850],
        (object)['name' => 'Fiona', 'score' => 830],
        (object)['name' => 'George', 'score' => 800],
        (object)['name' => 'Hannah', 'score' => 780],
        (object)['name' => 'Ian', 'score' => 750],
        (object)['name' => 'Julia', 'score' => 720],
    ])->sortByDesc('score')->values(); // sort dan reset index

    return view('leaderboard', ['leaders' => $leaders]);
    })->name('leaderboard');
});


/*
|--------------------------------------------------------------------------
| Admin Routes (Hanya untuk admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/quizzes', function () {
        $dummyQuizzes = [
            (object)['id' => 1, 'title' => 'Dasar Matematika', 'description' => 'Kuis sederhana tentang aritmatika.'],
            (object)['id' => 2, 'title' => 'Fakta Sains', 'description' => 'Uji pengetahuan sains umum Anda.'],
        ];
        return view('admin.quizzes.index', ['quizzes' => $dummyQuizzes]);
    })->name('quizzes.index');

    Route::get('/quizzes/create', function () {
        return view('admin.quizzes.create');
    })->name('quizzes.create');
});
