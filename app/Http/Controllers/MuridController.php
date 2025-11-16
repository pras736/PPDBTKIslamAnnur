<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Murid;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MuridController extends Controller
{
    /**
     * Menampilkan form pendaftaran murid baru
     */
    public function create()
    {
        return view('murid.create');
    }

    /**
     * Menyimpan data pendaftaran murid baru
     */
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            // Data Akun
            'username' => 'required|string|max:255|unique:akuns,username',
            'password' => 'required|string|min:8|confirmed',
            
            // Data Identitas Anak
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
            
            // Data Alamat
            'alamat_jalan' => 'nullable|string|max:255',
            'alamat_kelurahan' => 'nullable|string|max:100',
            'alamat_kecamatan' => 'nullable|string|max:100',
            'alamat_kota' => 'nullable|string|max:100',
            'alamat_provinsi' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            'jarak_sekolah' => 'nullable|string|max:50',
            
            // Kontak
            'telp_ayah' => 'nullable|string|max:20',
            'telp_ibu' => 'nullable|string|max:20',
            
            // Data Ayah
            'nama_ayah' => 'nullable|string|max:150',
            'nik_ayah' => 'nullable|string|max:20',
            'tempat_lahir_ayah' => 'nullable|string|max:100',
            'tanggal_lahir_ayah' => 'nullable|date',
            'pendidikan_ayah' => 'nullable|string|max:50',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            
            // Data Ibu
            'nama_ibu' => 'nullable|string|max:150',
            'nik_ibu' => 'nullable|string|max:20',
            'tempat_lahir_ibu' => 'nullable|string|max:100',
            'tanggal_lahir_ibu' => 'nullable|date',
            'pendidikan_ibu' => 'nullable|string|max:50',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            
            // Bukti Pembayaran (wajib saat pendaftaran pertama)
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // 1. Buat akun baru
            $akun = Akun::create([
                'username' => $validated['username'],
                'password' => Hash::make($validated['password']),
                'password_plain' => $validated['password'],
                'role' => 'wali',
            ]);

            // 2. Simpan bukti pembayaran
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

            // 3. Buat data murid
            $murid = Murid::create([
                'id_akun' => $akun->id_akun,
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

            // 4. Buat data pembayaran dengan status "menunggu"
            Pembayaran::create([
                'id_murid' => $murid->id_murid,
                'bukti_pembayaran' => $buktiPath,
                'status_pembayaran' => 'menunggu',
            ]);

            DB::commit();

            return redirect()->route('murid.show', $murid->id_murid)
                ->with('success', 'Pendaftaran berhasil! Data Anda sedang menunggu verifikasi pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
        }
    }

    /**
     * Menampilkan detail murid
     */
    public function show($id)
    {
        $murid = Murid::with(['akun', 'pembayaranTerbaru'])->findOrFail($id);
        return view('murid.show', compact('murid'));
    }

    /**
     * Menampilkan form edit profil murid
     */
    public function edit($id)
    {
        $murid = Murid::with('pembayaranTerbaru')->findOrFail($id);
        
        // Cek apakah pembayaran ditolak (boleh upload ulang)
        $bolehUploadBukti = false;
        if ($murid->pembayaranTerbaru && $murid->pembayaranTerbaru->status_pembayaran === 'ditolak') {
            $bolehUploadBukti = true;
        }
        
        return view('murid.edit', compact('murid', 'bolehUploadBukti'));
    }

    /**
     * Update data profil murid
     */
    public function update(Request $request, $id)
    {
        $murid = Murid::with('pembayaranTerbaru')->findOrFail($id);
        
        // Cek apakah pembayaran ditolak (boleh upload ulang)
        $bolehUploadBukti = false;
        if ($murid->pembayaranTerbaru && $murid->pembayaranTerbaru->status_pembayaran === 'ditolak') {
            $bolehUploadBukti = true;
        }

        // Validasi data
        $rules = [
            // Data Identitas Anak
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
            
            // Data Alamat
            'alamat_jalan' => 'nullable|string|max:255',
            'alamat_kelurahan' => 'nullable|string|max:100',
            'alamat_kecamatan' => 'nullable|string|max:100',
            'alamat_kota' => 'nullable|string|max:100',
            'alamat_provinsi' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            'jarak_sekolah' => 'nullable|string|max:50',
            
            // Kontak
            'telp_ayah' => 'nullable|string|max:20',
            'telp_ibu' => 'nullable|string|max:20',
            
            // Data Ayah
            'nama_ayah' => 'nullable|string|max:150',
            'nik_ayah' => 'nullable|string|max:20',
            'tempat_lahir_ayah' => 'nullable|string|max:100',
            'tanggal_lahir_ayah' => 'nullable|date',
            'pendidikan_ayah' => 'nullable|string|max:50',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            
            // Data Ibu
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
            // Update data murid
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

            return redirect()->route('murid.show', $murid->id_murid)
                ->with('success', 'Data profil berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage()]);
        }
    }

    /**
     * Method untuk admin/guru verifikasi pembayaran
     * Ketika pembayaran diverifikasi, status_siswa otomatis berubah dari "pendaftar" ke "terdaftar"
     */
    public function verifikasiPembayaran($idPembayaran)
    {
        $pembayaran = Pembayaran::with('murid')->findOrFail($idPembayaran);

        DB::beginTransaction();
        try {
            // Update status pembayaran menjadi "diverifikasi"
            $pembayaran->update([
                'status_pembayaran' => 'diverifikasi',
            ]);

            // Update status_siswa dari "pendaftar" menjadi "terdaftar"
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
     * Method untuk admin/guru tolak pembayaran
     */
    public function tolakPembayaran($idPembayaran)
    {
        $pembayaran = Pembayaran::findOrFail($idPembayaran);

        $pembayaran->update([
            'status_pembayaran' => 'ditolak',
        ]);

        return back()->with('success', 'Pembayaran ditolak. Wali murid dapat mengupload bukti pembayaran ulang.');
    }
}
