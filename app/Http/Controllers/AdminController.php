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
     * Fitur: menampilkan ringkasan statistik (total murid, pendaftar, terdaftar, dan pembayaran yang masih menunggu).
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
     * List semua pembayaran.
     * Fitur: halaman manajemen bukti pembayaran untuk admin (pagination + filter status + search).
     */
    public function pembayaranIndex(Request $request)
    {
        $query = Pembayaran::with('murid')->latest();

        // Filter berdasarkan status pembayaran (menunggu/diverifikasi/ditolak)
        if ($request->filled('status_pembayaran') && $request->status_pembayaran !== 'all') {
            $query->where('status_pembayaran', $request->status_pembayaran);
        }

        // Search pembayaran (berdasarkan ID pembayaran, ID murid, atau nama murid)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id_pembayaran', 'LIKE', '%' . $search . '%')
                  ->orWhere('id_murid', 'LIKE', '%' . $search . '%')
                  ->orWhereHas('murid', function ($qm) use ($search) {
                      $qm->where('nama_lengkap', 'LIKE', '%' . $search . '%');
                  });
            });
        }

        $pembayarans = $query->paginate(10)->withQueryString();

        return view('admin.pembayaran.index', compact('pembayarans'));
    }

    /**
     * Verifikasi pembayaran.
     * Fitur: mengubah status pembayaran menjadi "diverifikasi" dan otomatis mengubah status siswa menjadi "terdaftar".
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
     * Tolak pembayaran.
     * Fitur: mengubah status pembayaran menjadi "ditolak" sehingga wali murid dapat upload ulang bukti pembayaran.
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
     * List semua murid.
     * Fitur: halaman manajemen murid untuk admin (pagination + filter jenis kelamin + search nama/NIK/username).
     */
    public function muridIndex(Request $request)
    {
        $query = Murid::with(['akun', 'pembayaranTerbaru'])->latest();

        // Filter berdasarkan jenis kelamin (L/P)
        if ($request->filled('jenis_kelamin') && $request->jenis_kelamin !== 'all') {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Search murid (nama, NIK, atau username akun)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', '%' . $search . '%')
                  ->orWhere('nik_anak', 'LIKE', '%' . $search . '%')
                  ->orWhereHas('akun', function ($qa) use ($search) {
                      $qa->where('username', 'LIKE', '%' . $search . '%');
                  });
            });
        }

        $murids = $query->paginate(10)->withQueryString();

        return view('admin.murid.index', compact('murids'));
    }

    /**
     * Detail murid.
     * Fitur: menampilkan profil lengkap murid beserta riwayat pembayaran.
     */
    public function muridShow($id)
    {
        $murid = Murid::with(['akun', 'pembayarans'])->findOrFail($id);
        return view('admin.murid.show', compact('murid'));
    }

    /**
     * Form create murid.
     * Fitur: halaman admin untuk menambahkan murid baru sekaligus membuat akun wali.
     */
    public function muridCreate()
    {
        return view('admin.murid.create');
    }

    /**
     * Store murid baru.
     * Fitur: menyimpan data murid baru dan akun walinya ke database.
     */
    public function muridStore(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:akuns,username',
            'password' => 'required|string|min:8|confirmed',
            'status_siswa' => 'required|in:pendaftar,terdaftar',
            'nama_lengkap' => 'required|string|max:150',
            'nik_anak' => 'nullable|string|max:20',
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
                'nik_anak' => $validated['nik_anak'] ?? null,
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
     * Form edit murid.
     * Fitur: halaman admin untuk mengubah data murid yang sudah terdaftar.
     */
    public function muridEdit($id)
    {
        $murid = Murid::with('akun')->findOrFail($id);
        return view('admin.murid.edit', compact('murid'));
    }

    /**
     * Update murid.
     * Fitur: menyimpan perubahan data murid dari form edit.
     */
    public function muridUpdate(Request $request, $id)
    {
        $murid = Murid::with('akun')->findOrFail($id);

        $validated = $request->validate([
            'status_siswa' => 'required|in:pendaftar,terdaftar',
            'nama_lengkap' => 'required|string|max:150',
            'nik_anak' => 'nullable|string|max:20',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
        ]);

        $murid->update($validated);

        return redirect()->route('admin.murid.index')
            ->with('success', 'Data murid berhasil diperbarui.');
    }

    /**
     * Delete murid.
     * Fitur: menghapus data murid sekaligus akun walinya dari sistem.
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
     * List semua guru.
     * Fitur: halaman manajemen guru untuk admin (pagination + filter status wali kelas + search NIP/username/nama kelas teks).
     */
    public function guruIndex(Request $request)
    {
        $query = Guru::with(['akun', 'kelas'])->latest();

        // Filter berdasarkan apakah guru sudah di-assign ke kelas atau belum
        if ($request->filled('status_kelas') && $request->status_kelas !== 'all') {
            if ($request->status_kelas === 'sudah') {
                // Guru yang sudah menjadi wali kelas (punya relasi kelas)
                $query->whereHas('kelas');
            } elseif ($request->status_kelas === 'belum') {
                // Guru yang belum menjadi wali kelas
                $query->whereDoesntHave('kelas');
            }
        }

        // Search guru (NIP, username, atau nama kelas teks)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('NIP', 'LIKE', '%' . $search . '%')
                  ->orWhere('kelas', 'LIKE', '%' . $search . '%')
                  ->orWhereHas('akun', function ($qa) use ($search) {
                      $qa->where('username', 'LIKE', '%' . $search . '%');
                  });
            });
        }

        $gurus = $query->paginate(10)->withQueryString();

        return view('admin.guru.index', compact('gurus'));
    }

    /**
     * Form create guru.
     * Fitur: halaman admin untuk menambahkan akun guru baru.
     */
    public function guruCreate()
    {
        return view('admin.guru.create');
    }

    /**
     * Store guru baru (dengan akun).
     * Fitur: menyimpan data guru baru dan akun login gurunya.
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
     * Form edit guru.
     * Fitur: halaman admin untuk mengubah data guru.
     */
    public function guruEdit($id)
    {
        $guru = Guru::with('akun')->findOrFail($id);
        return view('admin.guru.edit', compact('guru'));
    }

    /**
     * Update guru.
     * Fitur: menyimpan perubahan data guru dari form edit.
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
     * Delete guru.
     * Fitur: menghapus data guru dan akunnya dari sistem.
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
     * Reset password guru.
     * Fitur: mengatur ulang password akun guru ke nilai default "guru123".
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
     * Reset password murid.
     * Fitur: mengatur ulang password akun wali/murid ke nilai default "password123".
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
     * List semua kelas.
     * Fitur: halaman manajemen kelas untuk admin (pagination + filter kelas yang sudah/belum punya wali).
     */
    public function kelasIndex(Request $request)
    {
        $query = Kelas::with(['guru.akun', 'murids'])->latest();

        // Filter kelas berdasarkan apakah sudah memiliki wali kelas atau belum
        if ($request->filled('status_wali') && $request->status_wali !== 'all') {
            if ($request->status_wali === 'sudah') {
                $query->whereNotNull('id_guru');
            } elseif ($request->status_wali === 'belum') {
                $query->whereNull('id_guru');
            }
        }

        $kelas = $query->paginate(10)->withQueryString();

        return view('admin.kelas.index', compact('kelas'));
    }

    /**
     * Form create kelas.
     * Fitur: halaman admin untuk membuat kelas baru dan memilih wali kelas (opsional).
     */
    public function kelasCreate()
    {
        $gurus = Guru::with('akun')->get();
        return view('admin.kelas.create', compact('gurus'));
    }

    /**
     * Store kelas baru.
     * Fitur: menyimpan data kelas baru yang dibuat admin.
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
     * Form edit kelas.
     * Fitur: halaman admin untuk mengubah informasi kelas dan mengelola murid yang ada di kelas tersebut.
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
     * Update kelas.
     * Fitur: menyimpan perubahan data kelas dari form edit.
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
     * Delete kelas.
     * Fitur: menghapus kelas dari sistem (tanpa menghapus murid).
     */
    public function kelasDestroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Data kelas berhasil dihapus.');
    }

    /**
     * Assign murid ke kelas.
     * Fitur: menambahkan satu atau banyak murid ke kelas tertentu (set kolom id_kelas di tabel murids).
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
     * Remove murid dari kelas.
     * Fitur: mengeluarkan murid dari kelas dengan mengosongkan kolom id_kelas.
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
     * Export data murid ke Excel (CSV format untuk sementara).
     * Fitur: mengunduh seluruh data murid beserta status pembayaran terakhir dalam bentuk file CSV untuk admin.
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

