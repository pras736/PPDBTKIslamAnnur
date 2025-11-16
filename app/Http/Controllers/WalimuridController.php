<?php

namespace App\Http\Controllers;

use App\Models\Murid;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class WalimuridController extends Controller
{
    /**
     * Display the wali murid dashboard.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'wali') {
            return redirect()->route('login')->withErrors(['error' => 'Anda harus login sebagai wali murid.']);
        }

        // Ambil data murid dari akun yang login
        $murid = Murid::with(['pembayaranTerbaru'])->where('id_akun', $user->id_akun)->first();

        return view('walimurid.dashboard', compact('user', 'murid'));
    }

    /**
     * Form pendaftaran murid baru
     */
    public function create()
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'wali') {
            return redirect()->route('login')->withErrors(['error' => 'Anda harus login sebagai wali murid.']);
        }

        // Cek apakah sudah ada data murid
        $murid = Murid::where('id_akun', $user->id_akun)->first();
        if ($murid) {
            return redirect()->route('walimurid.dashboard')
                ->with('info', 'Data murid sudah terdaftar. Silakan edit data jika perlu.');
        }

        return view('walimurid.create');
    }

    /**
     * Simpan data pendaftaran murid baru
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'wali') {
            return redirect()->route('login')->withErrors(['error' => 'Anda harus login sebagai wali murid.']);
        }

        // Cek apakah sudah ada data murid
        $existingMurid = Murid::where('id_akun', $user->id_akun)->first();
        if ($existingMurid) {
            return redirect()->route('walimurid.dashboard')
                ->with('info', 'Data murid sudah terdaftar.');
        }

        // Validasi: Semua field wajib diisi
        $validated = $request->validate([
            'no_induk_sekolah' => 'required|string|max:50',
            'nik_anak' => 'required|string|max:20',
            'no_akte' => 'required|string|max:30',
            'nama_lengkap' => 'required|string|max:150',
            'nama_panggilan' => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:50',
            'kewarganegaraan' => 'required|string|max:50',
            'hobi' => 'required|string|max:100',
            'cita_cita' => 'required|string|max:100',
            'anak_ke' => 'required|integer',
            'jumlah_saudara' => 'required|integer',
            'golongan_darah' => 'required|string|max:5',
            'berat_badan' => 'required|numeric',
            'tinggi_badan' => 'required|numeric',
            'lingkar_kepala' => 'required|numeric',
            'imunisasi' => 'required|string|max:255',
            'alamat_jalan' => 'required|string|max:255',
            'alamat_kelurahan' => 'required|string|max:100',
            'alamat_kecamatan' => 'required|string|max:100',
            'alamat_kota' => 'required|string|max:100',
            'alamat_provinsi' => 'required|string|max:100',
            'kode_pos' => 'required|string|max:10',
            'jarak_sekolah' => 'required|string|max:50',
            'telp_ayah' => 'required|string|max:20',
            'telp_ibu' => 'required|string|max:20',
            'nama_ayah' => 'required|string|max:150',
            'nik_ayah' => 'required|string|max:20',
            'tempat_lahir_ayah' => 'required|string|max:100',
            'tanggal_lahir_ayah' => 'required|date',
            'pendidikan_ayah' => 'required|string|max:50',
            'pekerjaan_ayah' => 'required|string|max:100',
            'nama_ibu' => 'required|string|max:150',
            'nik_ibu' => 'required|string|max:20',
            'tempat_lahir_ibu' => 'required|string|max:100',
            'tanggal_lahir_ibu' => 'required|date',
            'pendidikan_ibu' => 'required|string|max:50',
            'pekerjaan_ibu' => 'required|string|max:100',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'required' => 'Field :attribute wajib diisi.',
        ]);

        DB::beginTransaction();
        try {
            // Buat data murid
            $murid = Murid::create([
                'id_akun' => $user->id_akun,
                'status_siswa' => 'pendaftar',
                'no_induk_sekolah' => $validated['no_induk_sekolah'] ?? null,
                'nik_anak' => $validated['nik_anak'] ?? null,
                'no_akte' => $validated['no_akte'] ?? null,
                'nama_lengkap' => $validated['nama_lengkap'],
                'nama_panggilan' => $validated['nama_panggilan'] ?? null,
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'tempat_lahir' => $validated['tempat_lahir'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'agama' => $validated['agama'] ?? null,
                'kewarganegaraan' => $validated['kewarganegaraan'] ?? null,
                'hobi' => $validated['hobi'] ?? null,
                'cita_cita' => $validated['cita_cita'] ?? null,
                'anak_ke' => $validated['anak_ke'] ?? null,
                'jumlah_saudara' => $validated['jumlah_saudara'] ?? null,
                'golongan_darah' => $validated['golongan_darah'] ?? null,
                'berat_badan' => $validated['berat_badan'] ?? null,
                'tinggi_badan' => $validated['tinggi_badan'] ?? null,
                'lingkar_kepala' => $validated['lingkar_kepala'] ?? null,
                'imunisasi' => $validated['imunisasi'] ?? null,
                'alamat_jalan' => $validated['alamat_jalan'] ?? null,
                'alamat_kelurahan' => $validated['alamat_kelurahan'] ?? null,
                'alamat_kecamatan' => $validated['alamat_kecamatan'] ?? null,
                'alamat_kota' => $validated['alamat_kota'] ?? null,
                'alamat_provinsi' => $validated['alamat_provinsi'] ?? null,
                'kode_pos' => $validated['kode_pos'] ?? null,
                'jarak_sekolah' => $validated['jarak_sekolah'] ?? null,
                'telp_ayah' => $validated['telp_ayah'] ?? null,
                'telp_ibu' => $validated['telp_ibu'] ?? null,
                'nama_ayah' => $validated['nama_ayah'] ?? null,
                'nik_ayah' => $validated['nik_ayah'] ?? null,
                'tempat_lahir_ayah' => $validated['tempat_lahir_ayah'] ?? null,
                'tanggal_lahir_ayah' => $validated['tanggal_lahir_ayah'] ?? null,
                'pendidikan_ayah' => $validated['pendidikan_ayah'] ?? null,
                'pekerjaan_ayah' => $validated['pekerjaan_ayah'] ?? null,
                'nama_ibu' => $validated['nama_ibu'] ?? null,
                'nik_ibu' => $validated['nik_ibu'] ?? null,
                'tempat_lahir_ibu' => $validated['tempat_lahir_ibu'] ?? null,
                'tanggal_lahir_ibu' => $validated['tanggal_lahir_ibu'] ?? null,
                'pendidikan_ibu' => $validated['pendidikan_ibu'] ?? null,
                'pekerjaan_ibu' => $validated['pekerjaan_ibu'] ?? null,
            ]);

            // Simpan bukti pembayaran
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

            // Buat data pembayaran dengan status "menunggu"
            Pembayaran::create([
                'id_murid' => $murid->id_murid,
                'bukti_pembayaran' => $buktiPath,
                'status_pembayaran' => 'menunggu',
            ]);

            DB::commit();

            return redirect()->route('walimurid.dashboard')
                ->with('success', 'Pendaftaran berhasil! Data Anda sedang menunggu verifikasi pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
        }
    }

    /**
     * Form edit data murid
     */
    public function edit()
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'wali') {
            return redirect()->route('login')->withErrors(['error' => 'Anda harus login sebagai wali murid.']);
        }

        $murid = Murid::with('pembayaranTerbaru')->where('id_akun', $user->id_akun)->firstOrFail();
        
        // Cek apakah pembayaran ditolak (boleh upload ulang)
        $bolehUploadBukti = false;
        if ($murid->pembayaranTerbaru && $murid->pembayaranTerbaru->status_pembayaran === 'ditolak') {
            $bolehUploadBukti = true;
        }
        
        return view('walimurid.edit', compact('murid', 'bolehUploadBukti'));
    }

    /**
     * Update data murid
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'wali') {
            return redirect()->route('login')->withErrors(['error' => 'Anda harus login sebagai wali murid.']);
        }

        $murid = Murid::with('pembayaranTerbaru')->where('id_akun', $user->id_akun)->firstOrFail();
        
        // Cek apakah pembayaran ditolak (boleh upload ulang)
        $bolehUploadBukti = false;
        if ($murid->pembayaranTerbaru && $murid->pembayaranTerbaru->status_pembayaran === 'ditolak') {
            $bolehUploadBukti = true;
        }

        $rules = [
            'no_induk_sekolah' => 'nullable|string|max:50',
            'nik_anak' => 'nullable|string|max:20',
            'no_akte' => 'nullable|string|max:30',
            'nama_lengkap' => 'required|string|max:150',
            'nama_panggilan' => 'nullable|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'agama' => 'nullable|string|max:50',
            'kewarganegaraan' => 'nullable|string|max:50',
            'hobi' => 'nullable|string|max:100',
            'cita_cita' => 'nullable|string|max:100',
            'anak_ke' => 'nullable|integer',
            'jumlah_saudara' => 'nullable|integer',
            'golongan_darah' => 'nullable|string|max:5',
            'berat_badan' => 'nullable|numeric',
            'tinggi_badan' => 'nullable|numeric',
            'lingkar_kepala' => 'nullable|numeric',
            'imunisasi' => 'nullable|string|max:255',
            'alamat_jalan' => 'nullable|string|max:255',
            'alamat_kelurahan' => 'nullable|string|max:100',
            'alamat_kecamatan' => 'nullable|string|max:100',
            'alamat_kota' => 'nullable|string|max:100',
            'alamat_provinsi' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            'jarak_sekolah' => 'nullable|string|max:50',
            'telp_ayah' => 'nullable|string|max:20',
            'telp_ibu' => 'nullable|string|max:20',
            'nama_ayah' => 'nullable|string|max:150',
            'nik_ayah' => 'nullable|string|max:20',
            'tempat_lahir_ayah' => 'nullable|string|max:100',
            'tanggal_lahir_ayah' => 'nullable|date',
            'pendidikan_ayah' => 'nullable|string|max:50',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'nama_ibu' => 'nullable|string|max:150',
            'nik_ibu' => 'nullable|string|max:20',
            'tempat_lahir_ibu' => 'nullable|string|max:100',
            'tanggal_lahir_ibu' => 'nullable|date',
            'pendidikan_ibu' => 'nullable|string|max:50',
            'pekerjaan_ibu' => 'nullable|string|max:100',
        ];

        // Jika pembayaran ditolak, bukti pembayaran wajib diupload ulang
        if ($bolehUploadBukti) {
            $rules['bukti_pembayaran'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:2048';
        } else {
            $rules['bukti_pembayaran'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048';
        }

        $validated = $request->validate($rules);

        DB::beginTransaction();
        try {
            // Update data murid (tidak boleh ubah id_murid dan id_akun)
            $murid->update([
                'no_induk_sekolah' => $validated['no_induk_sekolah'] ?? null,
                'nik_anak' => $validated['nik_anak'] ?? null,
                'no_akte' => $validated['no_akte'] ?? null,
                'nama_lengkap' => $validated['nama_lengkap'],
                'nama_panggilan' => $validated['nama_panggilan'] ?? null,
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'tempat_lahir' => $validated['tempat_lahir'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'agama' => $validated['agama'] ?? null,
                'kewarganegaraan' => $validated['kewarganegaraan'] ?? null,
                'hobi' => $validated['hobi'] ?? null,
                'cita_cita' => $validated['cita_cita'] ?? null,
                'anak_ke' => $validated['anak_ke'] ?? null,
                'jumlah_saudara' => $validated['jumlah_saudara'] ?? null,
                'golongan_darah' => $validated['golongan_darah'] ?? null,
                'berat_badan' => $validated['berat_badan'] ?? null,
                'tinggi_badan' => $validated['tinggi_badan'] ?? null,
                'lingkar_kepala' => $validated['lingkar_kepala'] ?? null,
                'imunisasi' => $validated['imunisasi'] ?? null,
                'alamat_jalan' => $validated['alamat_jalan'] ?? null,
                'alamat_kelurahan' => $validated['alamat_kelurahan'] ?? null,
                'alamat_kecamatan' => $validated['alamat_kecamatan'] ?? null,
                'alamat_kota' => $validated['alamat_kota'] ?? null,
                'alamat_provinsi' => $validated['alamat_provinsi'] ?? null,
                'kode_pos' => $validated['kode_pos'] ?? null,
                'jarak_sekolah' => $validated['jarak_sekolah'] ?? null,
                'telp_ayah' => $validated['telp_ayah'] ?? null,
                'telp_ibu' => $validated['telp_ibu'] ?? null,
                'nama_ayah' => $validated['nama_ayah'] ?? null,
                'nik_ayah' => $validated['nik_ayah'] ?? null,
                'tempat_lahir_ayah' => $validated['tempat_lahir_ayah'] ?? null,
                'tanggal_lahir_ayah' => $validated['tanggal_lahir_ayah'] ?? null,
                'pendidikan_ayah' => $validated['pendidikan_ayah'] ?? null,
                'pekerjaan_ayah' => $validated['pekerjaan_ayah'] ?? null,
                'nama_ibu' => $validated['nama_ibu'] ?? null,
                'nik_ibu' => $validated['nik_ibu'] ?? null,
                'tempat_lahir_ibu' => $validated['tempat_lahir_ibu'] ?? null,
                'tanggal_lahir_ibu' => $validated['tanggal_lahir_ibu'] ?? null,
                'pendidikan_ibu' => $validated['pendidikan_ibu'] ?? null,
                'pekerjaan_ibu' => $validated['pekerjaan_ibu'] ?? null,
            ]);

            // Jika ada upload bukti pembayaran baru (hanya jika pembayaran ditolak)
            if ($bolehUploadBukti && $request->hasFile('bukti_pembayaran')) {
                // Hapus bukti lama jika ada
                if ($murid->pembayaranTerbaru && $murid->pembayaranTerbaru->bukti_pembayaran) {
                    Storage::disk('public')->delete($murid->pembayaranTerbaru->bukti_pembayaran);
                }

                // Simpan bukti baru
                $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

                // Update atau buat pembayaran baru dengan status "menunggu"
                if ($murid->pembayaranTerbaru) {
                    $murid->pembayaranTerbaru->update([
                        'bukti_pembayaran' => $buktiPath,
                        'status_pembayaran' => 'menunggu',
                    ]);
                } else {
                    Pembayaran::create([
                        'id_murid' => $murid->id_murid,
                        'bukti_pembayaran' => $buktiPath,
                        'status_pembayaran' => 'menunggu',
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('walimurid.dashboard')
                ->with('success', 'Data profil berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage()]);
        }
    }
}
