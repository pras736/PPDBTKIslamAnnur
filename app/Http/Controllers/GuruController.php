<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Murid;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    /**
     * Dashboard Guru
     */
    public function dashboard()
    {
        // Ambil guru yang login
        $user = Auth::user();
        $guru = Guru::where('id_akun', $user->id_akun)->first();
        
        // Ambil kelas yang diajar oleh guru yang login
        if ($guru) {
            $kelas = Kelas::with(['guru.akun', 'murids'])
                ->where('id_guru', $guru->id_guru)
                ->get();
        } else {
            $kelas = collect();
        }
        
        return view('guru.dashboard', compact('kelas', 'guru'));
    }

    /**
     * Lihat detail kelas dengan murid-muridnya
     */
    public function kelasShow($id)
    {
        // Ambil guru yang login
        $user = Auth::user();
        $guru = Guru::where('id_akun', $user->id_akun)->first();
        
        // Ambil kelas yang diajar oleh guru yang login
        $kelas = Kelas::with(['guru.akun', 'murids.akun', 'murids.pembayaranTerbaru'])
            ->where('id_kelas', $id)
            ->where('id_guru', $guru ? $guru->id_guru : null)
            ->firstOrFail();
        
        // Ambil murid di kelas ini
        $murids = Murid::where('id_kelas', $id)
            ->with(['akun', 'pembayaranTerbaru'])
            ->orderBy('nama_lengkap')
            ->get();
        
        return view('guru.kelas.show', compact('kelas', 'murids'));
    }
}

