<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Murid;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    /**
     * Dashboard Guru
     */
    public function dashboard()
    {
        // Ambil kelas yang diajar oleh guru yang login
        // Untuk sekarang, kita ambil semua kelas (bisa disesuaikan dengan relasi akun-guru)
        $kelas = Kelas::with(['guru', 'murids'])->get();
        
        return view('guru.dashboard', compact('kelas'));
    }

    /**
     * Lihat detail kelas
     */
    public function kelasShow($id)
    {
        $kelas = Kelas::with(['guru', 'murids'])->findOrFail($id);
        
        // Ambil semua murid yang terdaftar (bisa disesuaikan dengan relasi kelas-murid jika ada)
        // Untuk sekarang, kita ambil semua murid terdaftar
        $murids = Murid::where('status_siswa', 'terdaftar')->get();
        
        return view('guru.kelas.show', compact('kelas', 'murids'));
    }
}

