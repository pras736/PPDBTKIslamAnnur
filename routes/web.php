<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

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

    if (Auth::attempt($credentials, $remember)) {
        $request->session()->regenerate();
        return redirect()->intended('/home');
    }

    return back()->withErrors([
        'email' => 'Email atau kata sandi salah.',
    ])->withInput($request->only('email'));
});

// Logout (POST)
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');
