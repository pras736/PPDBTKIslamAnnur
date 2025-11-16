<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\WalimuridController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;

// ============================================
// PUBLIC ROUTES (Tanpa Login)
// ============================================

// Home page - redirect jika sudah login
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'guru') {
            return redirect()->route('guru.dashboard');
        } elseif ($user->role === 'wali') {
            return redirect()->route('walimurid.dashboard');
        }
    }
    return view('home');
})->name('home');

Route::get('/home',[HomeController::class, 'index'])->name('home.index');

// Registrasi akun wali murid (public)
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Login form (GET)
Route::get('/login', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'guru') {
            return redirect()->route('guru.dashboard');
        } elseif ($user->role === 'wali') {
            return redirect()->route('walimurid.dashboard');
        }
    }
    return view('auth.login');
})->name('login');

// Login handler (POST)
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'username' => ['required', 'string'],
        'password' => ['required'],
    ]);

    $remember = $request->filled('remember');

    if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']], $remember)) {
        $request->session()->regenerate();
        $user = Auth::user();
        
        // Redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        } elseif ($user->role === 'guru') {
            return redirect()->intended('/guru/dashboard');
        } elseif ($user->role === 'wali') {
            return redirect()->intended('/walimurid/dashboard');
        }
        
        return redirect()->intended('/home');
    }

    return back()->withErrors([
        'username' => 'Username atau password salah.',
    ])->withInput($request->only('username'));
});

// Logout (POST)
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// ============================================
// WALI MURID ROUTES (Middleware: auth + role:wali)
// ============================================
Route::middleware(['auth', 'role:wali'])->prefix('walimurid')->name('walimurid.')->group(function () {
    Route::get('/dashboard', [WalimuridController::class, 'index'])->name('dashboard');
    Route::get('/create', [WalimuridController::class, 'create'])->name('create');
    Route::post('/store', [WalimuridController::class, 'store'])->name('store');
    Route::get('/edit', [WalimuridController::class, 'edit'])->name('edit');
    Route::put('/update', [WalimuridController::class, 'update'])->name('update');
});

// ============================================
// GURU ROUTES (Middleware: auth + role:guru)
// ============================================
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('dashboard');
    Route::get('/kelas/{id}', [GuruController::class, 'kelasShow'])->name('kelas.show');
});

// ============================================
// ADMIN ROUTES (Middleware: auth + role:admin)
// ============================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Pembayaran
    Route::get('/pembayaran', [AdminController::class, 'pembayaranIndex'])->name('pembayaran.index');
    Route::post('/pembayaran/{id}/verifikasi', [AdminController::class, 'verifikasiPembayaran'])->name('pembayaran.verifikasi');
    Route::post('/pembayaran/{id}/tolak', [AdminController::class, 'tolakPembayaran'])->name('pembayaran.tolak');
    
    // Murid
    Route::get('/murid', [AdminController::class, 'muridIndex'])->name('murid.index');
    Route::get('/murid/create', [AdminController::class, 'muridCreate'])->name('murid.create');
    Route::post('/murid/store', [AdminController::class, 'muridStore'])->name('murid.store');
    Route::get('/murid/{id}', [AdminController::class, 'muridShow'])->name('murid.show');
    Route::get('/murid/{id}/edit', [AdminController::class, 'muridEdit'])->name('murid.edit');
    Route::put('/murid/{id}', [AdminController::class, 'muridUpdate'])->name('murid.update');
    Route::delete('/murid/{id}', [AdminController::class, 'muridDestroy'])->name('murid.destroy');
    
    // Guru
    Route::get('/guru', [AdminController::class, 'guruIndex'])->name('guru.index');
    Route::get('/guru/create', [AdminController::class, 'guruCreate'])->name('guru.create');
    Route::post('/guru/store', [AdminController::class, 'guruStore'])->name('guru.store');
    Route::get('/guru/{id}/edit', [AdminController::class, 'guruEdit'])->name('guru.edit');
    Route::put('/guru/{id}', [AdminController::class, 'guruUpdate'])->name('guru.update');
    Route::delete('/guru/{id}', [AdminController::class, 'guruDestroy'])->name('guru.destroy');
    Route::post('/guru/{id}/reset-password', [AdminController::class, 'guruResetPassword'])->name('guru.reset-password');
    
    // Kelas
    Route::get('/kelas', [AdminController::class, 'kelasIndex'])->name('kelas.index');
    Route::get('/kelas/create', [AdminController::class, 'kelasCreate'])->name('kelas.create');
    Route::post('/kelas/store', [AdminController::class, 'kelasStore'])->name('kelas.store');
    Route::get('/kelas/{id}/edit', [AdminController::class, 'kelasEdit'])->name('kelas.edit');
    Route::put('/kelas/{id}', [AdminController::class, 'kelasUpdate'])->name('kelas.update');
    Route::delete('/kelas/{id}', [AdminController::class, 'kelasDestroy'])->name('kelas.destroy');
    
    // Export Excel
    Route::get('/export/murid', [AdminController::class, 'exportMuridExcel'])->name('export.murid');
});
