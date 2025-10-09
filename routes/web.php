<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WalimuridController;

Route::get('/', function () {
    return view('home');
});

Route::get('/home',[HomeController::class, 'index']);

// Login form (GET)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Login handler (POST)
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $remember = $request->filled('remember');

    // Jika ada sistem Auth (DB), gunakan Auth::attempt seperti biasa
    try {
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/home');
        }
    } catch (\Throwable $e) {
        // Jika tidak ada DB (development/demo), kita akan buat sesi demo sederhana
    }

    // Demo fallback: terima credential demo tertentu (konfigurable via .env)
    $demoEmail = env('DEMO_LOGIN_EMAIL', 'prasetio24ti@mahasiswa.pcr.ac.id');
    $demoPassword = env('DEMO_LOGIN_PASSWORD', 'prasetiopcr07');

    if ($credentials['email'] === $demoEmail && $credentials['password'] === $demoPassword) {
        // Simpan info user demo di session
        $request->session()->put('walimurid_user', [
            'name' => 'Bapak/Ibu Contoh',
            'email' => $demoEmail,
            'role' => 'walimurid',
        ]);
        return redirect()->intended('/walimurid');
    }

    return back()->withErrors([
        'email' => "Email atau kata sandi salah. (Gunakan {$demoEmail} / {$demoPassword} untuk demo)",
    ])->withInput($request->only('email'));
});

// Logout (POST)
Route::post('/logout', function (Request $request) {
    // Clear real auth if present
    try { Auth::logout(); } catch (\Throwable $e) {}
    // Clear demo session
    $request->session()->forget('walimurid_user');
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Wali Murid dashboard (demo-friendly: no DB required)
Route::get('/walimurid', [WalimuridController::class, 'index'])->name('walimurid.dashboard');
