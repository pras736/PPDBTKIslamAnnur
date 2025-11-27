<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\WalimuridController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
| Disusun per controller agar mudah dipindai.
*/
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'guru') {
            return redirect()->route('guru.dashboard');
        }

        if ($user->role === 'wali') {
            return redirect()->route('walimurid.dashboard');
        }
    }

    return view('home');
})->name('home');

Route::controller(HomeController::class)->group(function () {
    Route::get('/home', 'index')->name('home.index');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register')->name('register.post');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if ($user->role === 'guru') {
                return redirect()->route('guru.dashboard');
            }

            if ($user->role === 'wali') {
                return redirect()->route('walimurid.dashboard');
            }
        }

        return view('auth.login');
    })->name('login');

    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $remember = $request->filled('remember');

        if (Auth::attempt([
            'username' => $credentials['username'],
            'password' => $credentials['password'],
        ], $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }

            if ($user->role === 'guru') {
                return redirect()->intended('/guru/dashboard');
            }

            if ($user->role === 'wali') {
                return redirect()->intended('/walimurid/dashboard');
            }

            return redirect()->intended('/home');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput($request->only('username'));
    });
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
})->name('logout');

/*
|--------------------------------------------------------------------------
| AdminController
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->controller(AdminController::class)
    ->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');

        // Guru
        Route::get('/guru', 'guruIndex')->name('guru.index');
        Route::get('/guru/create', 'guruCreate')->name('guru.create');
        Route::post('/guru/store', 'guruStore')->name('guru.store');
        Route::get('/guru/{id}/edit', 'guruEdit')->name('guru.edit');
        Route::put('/guru/{id}', 'guruUpdate')->name('guru.update');
        Route::delete('/guru/{id}', 'guruDestroy')->name('guru.destroy');
        Route::post('/guru/{id}/reset-password', 'guruResetPassword')->name('guru.reset-password');

        // Kelas
        Route::get('/kelas', 'kelasIndex')->name('kelas.index');
        Route::get('/kelas/create', 'kelasCreate')->name('kelas.create');
        Route::post('/kelas/store', 'kelasStore')->name('kelas.store');
        Route::get('/kelas/{id}/edit', 'kelasEdit')->name('kelas.edit');
        Route::put('/kelas/{id}', 'kelasUpdate')->name('kelas.update');
        Route::delete('/kelas/{id}', 'kelasDestroy')->name('kelas.destroy');
        Route::post('/kelas/{id}/assign-murid', 'kelasAssignMurid')->name('kelas.assignMurid');
        Route::post('/kelas/{idKelas}/remove-murid/{idMurid}', 'kelasRemoveMurid')->name('kelas.removeMurid');

        // Murid
        Route::get('/murid', 'muridIndex')->name('murid.index');
        Route::get('/murid/create', 'muridCreate')->name('murid.create');
        Route::post('/murid/store', 'muridStore')->name('murid.store');
        Route::get('/murid/{id}', 'muridShow')->name('murid.show');
        Route::get('/murid/{id}/edit', 'muridEdit')->name('murid.edit');
        Route::put('/murid/{id}', 'muridUpdate')->name('murid.update');
        Route::delete('/murid/{id}', 'muridDestroy')->name('murid.destroy');
        Route::post('/murid/{id}/reset-password', 'muridResetPassword')->name('murid.reset-password');

        // Pembayaran
        Route::get('/pembayaran', 'pembayaranIndex')->name('pembayaran.index');
        Route::post('/pembayaran/{id}/verifikasi', 'verifikasiPembayaran')->name('pembayaran.verifikasi');
        Route::post('/pembayaran/{id}/tolak', 'tolakPembayaran')->name('pembayaran.tolak');

        // Export
        Route::get('/export/murid', 'exportMuridExcel')->name('export.murid');
    });

/*
|--------------------------------------------------------------------------
| GuruController
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:guru'])
    ->prefix('guru')
    ->name('guru.')
    ->controller(GuruController::class)
    ->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/kelas/{id}', 'kelasShow')->name('kelas.show');
    });

/*
|--------------------------------------------------------------------------
| WalimuridController
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:wali'])
    ->prefix('walimurid')
    ->name('walimurid.')
    ->controller(WalimuridController::class)
    ->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit', 'edit')->name('edit');
        Route::put('/update', 'update')->name('update');
    });
