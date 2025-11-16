<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Menampilkan form registrasi akun wali murid
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Menyimpan registrasi akun wali murid
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:akuns,username',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Buat akun baru dengan role 'wali'
        $akun = Akun::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'password_plain' => $request->password,
            'role' => 'wali',
        ]);

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil! Silakan login dengan username dan password Anda.');
    }
}

