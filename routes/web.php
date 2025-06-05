<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    return view('home');
});

// Route ke halaman Profile
Route::get('/profile', function () {
    // sementara, pake data user dummy dulu biar ga error
    $dummyUser = (object) [
        'name' => 'Pengguna Saat Ini',
        'username' => 'pengguna01',
        'email' => 'pengguna@example.com',
        'joined_at' => now()->subDays(15),
        'quizzes_done' => 7
    ];
    return view('profile', ['user' => $dummyUser]);
});

// Route ke halaman Settings
Route::get('/settings', function () {
    $dummyUser = (object) [
        'username' => 'pengguna01',
        'email' => 'pengguna@example.com',
    ];
    return view('settings', ['user' => $dummyUser]);
});

// Route ke form Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Route untuk proses login
Route::post('/login', function (Request $request) {
    // Debug: Cek data yang diterima
    Log::info('Login attempt data:', $request->all());
    
    $request->validate([
        'login' => 'required|string', 
        'password' => 'required|string',
    ]);

    // Tentukan apakah input adalah email atau username
    $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    
    $credentials = [
        $loginField => $request->login,
        'password' => $request->password
    ];

    Log::info('Login credentials:', $credentials);

    if (Auth::attempt($credentials, $request->boolean('remember'))) { 
        $request->session()->regenerate(); 

        // Cek apakah pengguna adalah admin
        if (Auth::user()->is_admin) { 
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended('/'); 
    }

    return back()->withErrors([
        'login' => 'Username/email atau password salah.', 
    ])->onlyInput('login'); 
});

// Route ke form Signup/Register
Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup');

Route::post('/signup', function (Request $request) {
    // Debug: Cek data yang diterima
    Log::info('Signup attempt data:', $request->all());
    
    // Validasi data input
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Buat pengguna baru
    try {
        $user = User::create([
            'name' => $validatedData['name'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'is_admin' => false, // Secara default, pengguna baru bukan admin
        ]);

        // Langsung login-kan pengguna setelah berhasil registrasi
        Auth::login($user);

        // Redirect ke halaman home dengan pesan sukses
        return redirect('/')->with('success', 'Registrasi berhasil! Selamat datang!');

    } catch (\Illuminate\Database\QueryException $e) {
        Log::error('Signup QueryException: ' . $e->getMessage() . ' SQL: ' . $e->getSql() . ' Bindings: ' . implode(', ', $e->getBindings()));
        return back()->withInput()->withErrors(['error_signup' => 'Gagal mendaftarkan pengguna. Username atau email mungkin sudah digunakan.']);
    } catch (\Exception $e) {
        Log::error('Signup General Exception: ' . $e->getMessage());
        return back()->withInput()->withErrors(['error_signup' => 'Terjadi kesalahan yang tidak terduga. Silakan coba lagi.']);
    }
});

// Route untuk logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    return redirect('/');
})->name('logout');

// Route ke halaman Admin 
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/quizzes', function() {
        $dummyQuizzes = [
            (object)['id' => 1, 'title' => 'Dasar Matematika', 'description' => 'Kuis sederhana tentang aritmatika.'],
            (object)['id' => 2, 'title' => 'Fakta Sains', 'description' => 'Uji pengetahuan sains umum Anda.'],
        ];
        return view('admin.quizzes.index', ['quizzes' => $dummyQuizzes]);
    })->name('quizzes.index');

    Route::get('/quizzes/create', function() {
        return view('admin.quizzes.create');
    })->name('quizzes.create');
});