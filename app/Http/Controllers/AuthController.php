<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Fitur: Redirect ke Google OAuth untuk login/registrasi dengan Google
     * 
     * Mengarahkan user ke halaman login Google untuk autentikasi.
     * Setelah user setuju, Google akan redirect kembali ke callback URL.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Fitur: Handle callback dari Google OAuth setelah user login dengan Google
     * 
     * Setelah user berhasil login dengan Google, Google akan mengirim callback
     * ke method ini. Method ini akan:
     * 1. Ambil data user dari Google (email, name, dll)
     * 2. Cek apakah email sudah terdaftar di database
     * 3. Jika belum terdaftar, buat akun baru dengan role 'wali'
     * 4. Jika sudah terdaftar, langsung login
     * 5. Redirect ke dashboard sesuai role
     */
    public function handleGoogleCallback()
    {
        try {
            // Ambil data user dari Google
            $googleUser = Socialite::driver('google')->stateless()->user();
            
            // Ambil email dari Google (wajib ada)
            $email = $googleUser->email;
            $name = $googleUser->name ?? $googleUser->nickname ?? 'User';
            
            if (!$email) {
                return redirect()->route('login')
                    ->withErrors(['error' => 'Email tidak ditemukan dari akun Google.']);
            }

            // Cek apakah email sudah terdaftar sebagai username
            $akun = Akun::where('username', $email)->first();

            if ($akun) {
                // Jika sudah terdaftar, langsung login
                Auth::login($akun);
            } else {
                // Jika belum terdaftar, buat akun baru dengan role 'wali'
                // Generate password random untuk keamanan (tapi user tidak perlu tahu karena login via Google)
                $randomPassword = bin2hex(random_bytes(16));
                
                $akun = Akun::create([
                    'username' => $email,
                    'password' => Hash::make($randomPassword),
                    'password_plain' => $randomPassword, // Simpan untuk admin (jika perlu)
                    'role' => 'wali', // Default role untuk registrasi via Google adalah wali murid
                ]);

                // Login otomatis setelah registrasi
                Auth::login($akun);
            }

            // Redirect berdasarkan role
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->role === 'guru') {
                return redirect()->intended('/guru/dashboard');
            } elseif ($user->role === 'wali') {
                return redirect()->intended('/walimurid/dashboard');
            }

            return redirect()->intended('/home');

        } catch (\Exception $e) {
            // Jika terjadi error (misalnya user cancel, atau ada masalah dengan Google OAuth)
            return redirect()->route('login')
                ->withErrors(['error' => 'Gagal login dengan Google: ' . $e->getMessage()]);
        }
    }
}

