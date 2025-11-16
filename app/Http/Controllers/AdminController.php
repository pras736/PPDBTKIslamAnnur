<?php

namespace App\Http\Controllers;

use App\Models\Murid;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
// Excel export akan menggunakan library yang tersedia

class AdminController extends Controller
{
    /**
     * Dashboard Admin
     */
    public function dashboard()
    {
        $totalMurid = Murid::count();
        $totalPendaftar = Murid::where('status_siswa', 'pendaftar')->count();
        $totalTerdaftar = Murid::where('status_siswa', 'terdaftar')->count();
        $totalPembayaranMenunggu = Pembayaran::where('status_pembayaran', 'menunggu')->count();
        
        return view('admin.dashboard', compact('totalMurid', 'totalPendaftar', 'totalTerdaftar', 'totalPembayaranMenunggu'));
    }

    /**
     * List semua pembayaran
     */
    public function pembayaranIndex()
    {
        $pembayarans = Pembayaran::with('murid')->latest()->get();
        return view('admin.pembayaran.index', compact('pembayarans'));
    }

    /**
     * Verifikasi pembayaran
     */
    public function verifikasiPembayaran($id)
    {
        $pembayaran = Pembayaran::with('murid')->findOrFail($id);

        DB::beginTransaction();
        try {
            $pembayaran->update([
                'status_pembayaran' => 'diverifikasi',
            ]);

            $pembayaran->murid->update([
                'status_siswa' => 'terdaftar',
            ]);

            DB::commit();

            return back()->with('success', 'Pembayaran berhasil diverifikasi. Status siswa berubah menjadi terdaftar.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Tolak pembayaran
     */
    public function tolakPembayaran($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        $pembayaran->update([
            'status_pembayaran' => 'ditolak',
        ]);

        return back()->with('success', 'Pembayaran ditolak. Wali murid dapat mengupload bukti pembayaran ulang.');
    }

    /**
     * List semua murid
     */
    public function muridIndex()
    {
        $murids = Murid::with(['akun', 'pembayaranTerbaru'])->latest()->get();
        return view('admin.murid.index', compact('murids'));
    }

    /**
     * Detail murid
     */
    public function muridShow($id)
    {
        $murid = Murid::with(['akun', 'pembayarans'])->findOrFail($id);
        return view('admin.murid.show', compact('murid'));
    }

    /**
     * Form create murid
     */
    public function muridCreate()
    {
        return view('admin.murid.create');
    }

    /**
     * Store murid baru
     */
    public function muridStore(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:akuns,username',
            'password' => 'required|string|min:8|confirmed',
            'status_siswa' => 'required|in:pendaftar,terdaftar',
            'nama_lengkap' => 'required|string|max:150',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            $akun = \App\Models\Akun::create([
                'username' => $validated['username'],
                'password' => bcrypt($validated['password']),
                'password_plain' => $validated['password'], // Simpan password plain untuk admin
                'role' => 'wali', // Role untuk wali murid
            ]);

            $murid = Murid::create([
                'id_akun' => $akun->id_akun,
                'status_siswa' => $validated['status_siswa'],
                'nama_lengkap' => $validated['nama_lengkap'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'tempat_lahir' => $validated['tempat_lahir'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
            ]);

            DB::commit();

            return redirect()->route('admin.murid.index')
                ->with('success', 'Data murid berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Form edit murid
     */
    public function muridEdit($id)
    {
        $murid = Murid::with('akun')->findOrFail($id);
        return view('admin.murid.edit', compact('murid'));
    }

    /**
     * Update murid
     */
    public function muridUpdate(Request $request, $id)
    {
        $murid = Murid::with('akun')->findOrFail($id);

        $validated = $request->validate([
            'status_siswa' => 'required|in:pendaftar,terdaftar',
            'nama_lengkap' => 'required|string|max:150',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
        ]);

        $murid->update($validated);

        return redirect()->route('admin.murid.index')
            ->with('success', 'Data murid berhasil diperbarui.');
    }

    /**
     * Delete murid
     */
    public function muridDestroy($id)
    {
        $murid = Murid::with('akun')->findOrFail($id);
        
        DB::beginTransaction();
        try {
            $murid->delete();
            $murid->akun->delete();
            
            DB::commit();
            
            return redirect()->route('admin.murid.index')
                ->with('success', 'Data murid berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * List semua guru
     */
    public function guruIndex()
    {
        $gurus = Guru::with(['akun', 'kelas'])->latest()->get();
        return view('admin.guru.index', compact('gurus'));
    }

    /**
     * Form create guru
     */
    public function guruCreate()
    {
        return view('admin.guru.create');
    }

    /**
     * Store guru baru (dengan akun)
     */
    public function guruStore(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:akuns,username',
            'password' => 'required|string|min:8|confirmed',
            'NIP' => 'required|string|unique:gurus,NIP',
            'kelas' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Buat akun guru
            $akun = \App\Models\Akun::create([
                'username' => $validated['username'],
                'password' => bcrypt($validated['password']),
                'password_plain' => $validated['password'], // Simpan password plain untuk admin
                'role' => 'guru',
            ]);

            // Buat data guru dengan relasi ke akun
            Guru::create([
                'id_akun' => $akun->id_akun,
                'NIP' => $validated['NIP'],
                'kelas' => $validated['kelas'] ?? null,
            ]);

            DB::commit();

            return redirect()->route('admin.guru.index')
                ->with('success', 'Akun guru berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Form edit guru
     */
    public function guruEdit($id)
    {
        $guru = Guru::with('akun')->findOrFail($id);
        return view('admin.guru.edit', compact('guru'));
    }

    /**
     * Update guru
     */
    public function guruUpdate(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $validated = $request->validate([
            'NIP' => 'required|string|unique:gurus,NIP,' . $id . ',id_guru',
            'kelas' => 'nullable|string',
        ]);

        $guru->update($validated);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    /**
     * Delete guru
     */
    public function guruDestroy($id)
    {
        $guru = Guru::with('akun')->findOrFail($id);
        
        DB::beginTransaction();
        try {
            $guru->delete();
            if ($guru->akun) {
                $guru->akun->delete();
            }
            
            DB::commit();
            
            return redirect()->route('admin.guru.index')
                ->with('success', 'Data guru berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Reset password guru
     */
    public function guruResetPassword($id)
    {
        $guru = Guru::with('akun')->findOrFail($id);
        
        if (!$guru->akun) {
            return back()->withErrors(['error' => 'Akun guru tidak ditemukan.']);
        }

        $newPassword = 'guru123'; // Password default
        $guru->akun->update([
            'password' => bcrypt($newPassword),
            'password_plain' => $newPassword,
        ]);

        return back()->with('success', 'Password berhasil direset. Password baru: ' . $newPassword);
    }

    /**
     * Reset password murid
     */
    public function muridResetPassword($id)
    {
        $murid = Murid::with('akun')->findOrFail($id);
        
        if (!$murid->akun) {
            return back()->withErrors(['error' => 'Akun murid tidak ditemukan.']);
        }

        $newPassword = 'password123'; // Password default
        $murid->akun->update([
            'password' => bcrypt($newPassword),
            'password_plain' => $newPassword,
        ]);

        return back()->with('success', 'Password berhasil direset. Password baru: ' . $newPassword);
    }

    /**
     * List semua kelas
     */
    public function kelasIndex()
    {
        $kelas = Kelas::with(['guru.akun', 'murids'])->latest()->get();
        return view('admin.kelas.index', compact('kelas'));
    }

    /**
     * Form create kelas
     */
    public function kelasCreate()
    {
        $gurus = Guru::with('akun')->get();
        return view('admin.kelas.create', compact('gurus'));
    }

    /**
     * Store kelas baru
     */
    public function kelasStore(Request $request)
    {
        $validated = $request->validate([
            'id_guru' => 'nullable|exists:gurus,id_guru',
            'nama_kelas' => 'required|string',
            'nama_guru' => 'nullable|string',
        ]);

        Kelas::create($validated);

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Data kelas berhasil ditambahkan.');
    }

    /**
     * Form edit kelas
     */
    public function kelasEdit($id)
    {
        $kelas = Kelas::with(['guru.akun', 'murids.akun', 'murids.pembayaranTerbaru'])->findOrFail($id);
        $gurus = Guru::with('akun')->get();
        
        // Ambil semua murid yang terdaftar dan belum ada kelas atau sudah di kelas ini
        $muridsTerdaftar = Murid::where('status_siswa', 'terdaftar')
            ->where(function($query) use ($id) {
                $query->whereNull('id_kelas')
                      ->orWhere('id_kelas', $id);
            })
            ->with(['akun', 'pembayaranTerbaru'])
            ->orderBy('nama_lengkap')
            ->get();
        
        return view('admin.kelas.edit', compact('kelas', 'gurus', 'muridsTerdaftar'));
    }

    /**
     * Update kelas
     */
    public function kelasUpdate(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $validated = $request->validate([
            'id_guru' => 'nullable|exists:gurus,id_guru',
            'nama_kelas' => 'required|string',
            'nama_guru' => 'nullable|string',
        ]);

        $kelas->update($validated);

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Data kelas berhasil diperbarui.');
    }

    /**
     * Delete kelas
     */
    public function kelasDestroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Data kelas berhasil dihapus.');
    }

    /**
     * Assign murid ke kelas
     */
    public function kelasAssignMurid(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $validated = $request->validate([
            'murid_ids' => 'required|array',
            'murid_ids.*' => 'exists:murids,id_murid',
        ]);

        DB::beginTransaction();
        try {
            // Update semua murid yang dipilih ke kelas ini
            Murid::whereIn('id_murid', $validated['murid_ids'])
                ->update(['id_kelas' => $id]);

            DB::commit();

            return redirect()->route('admin.kelas.edit', $id)
                ->with('success', 'Murid berhasil ditambahkan ke kelas.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove murid dari kelas
     */
    public function kelasRemoveMurid($idKelas, $idMurid)
    {
        $kelas = Kelas::findOrFail($idKelas);
        $murid = Murid::findOrFail($idMurid);

        DB::beginTransaction();
        try {
            if ($murid->id_kelas == $idKelas) {
                $murid->update(['id_kelas' => null]);
            }

            DB::commit();

            return redirect()->route('admin.kelas.edit', $idKelas)
                ->with('success', 'Murid berhasil dikeluarkan dari kelas.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Export data murid ke Excel (CSV format untuk sementara)
     */
    public function exportMuridExcel()
    {
        $murids = Murid::with(['akun', 'pembayaranTerbaru'])->get();

        $filename = 'data_murid_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($murids) {
            $file = fopen('php://output', 'w');
            
            // BOM untuk UTF-8 (agar Excel membaca dengan benar)
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header
            fputcsv($file, [
                'No', 'NIK Anak', 'Nama Lengkap', 'Nama Panggilan', 
                'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Agama',
                'Alamat Jalan', 'Alamat Kelurahan', 'Alamat Kecamatan', 
                'Alamat Kota', 'Alamat Provinsi', 'Kode Pos',
                'Nama Ayah', 'NIK Ayah', 'Pekerjaan Ayah', 'Pendidikan Ayah',
                'Nama Ibu', 'NIK Ibu', 'Pekerjaan Ibu', 'Pendidikan Ibu',
                'Status Siswa', 'Status Pembayaran'
            ], ';');
            
            // Data
            foreach ($murids as $index => $murid) {
                fputcsv($file, [
                    $index + 1,
                    $murid->nik_anak ?? '',
                    $murid->nama_lengkap ?? '',
                    $murid->nama_panggilan ?? '',
                    $murid->jenis_kelamin ?? '',
                    $murid->tempat_lahir ?? '',
                    $murid->tanggal_lahir ? $murid->tanggal_lahir->format('Y-m-d') : '',
                    $murid->agama ?? '',
                    $murid->alamat_jalan ?? '',
                    $murid->alamat_kelurahan ?? '',
                    $murid->alamat_kecamatan ?? '',
                    $murid->alamat_kota ?? '',
                    $murid->alamat_provinsi ?? '',
                    $murid->kode_pos ?? '',
                    $murid->nama_ayah ?? '',
                    $murid->nik_ayah ?? '',
                    $murid->pekerjaan_ayah ?? '',
                    $murid->pendidikan_ayah ?? '',
                    $murid->nama_ibu ?? '',
                    $murid->nik_ibu ?? '',
                    $murid->pekerjaan_ibu ?? '',
                    $murid->pendidikan_ibu ?? '',
                    $murid->status_siswa ?? '',
                    $murid->pembayaranTerbaru ? $murid->pembayaranTerbaru->status_pembayaran : '',
                ], ';');
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

