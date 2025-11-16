<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Murid extends Model
{
    protected $table = 'murids';
    protected $primaryKey = 'id_murid';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_akun',
        'status_siswa',
        'no_induk_sekolah',
        'nisn',
        'nik_anak',
        'no_akte',
        'nama_lengkap',
        'nama_panggilan',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'kewarganegaraan',
        'hobi',
        'cita_cita',
        'anak_ke',
        'jumlah_saudara',
        'golongan_darah',
        'berat_badan',
        'tinggi_badan',
        'lingkar_kepala',
        'imunisasi',
        'alamat_jalan',
        'alamat_kelurahan',
        'alamat_kecamatan',
        'alamat_kota',
        'alamat_provinsi',
        'kode_pos',
        'jarak_sekolah',
        'telp_ayah',
        'telp_ibu',
        'nama_ayah',
        'nik_ayah',
        'tempat_lahir_ayah',
        'tanggal_lahir_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'nama_ibu',
        'nik_ibu',
        'tempat_lahir_ibu',
        'tanggal_lahir_ibu',
        'pendidikan_ibu',
        'pekerjaan_ibu',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_lahir_ayah' => 'date',
        'tanggal_lahir_ibu' => 'date',
        'berat_badan' => 'float',
        'tinggi_badan' => 'float',
        'lingkar_kepala' => 'float',
        'anak_ke' => 'integer',
        'jumlah_saudara' => 'integer',
    ];

    // Relasi 1:1 dengan Akun
    public function akun()
    {
        return $this->belongsTo(Akun::class, 'id_akun', 'id_akun');
    }

    // Relasi 1:M dengan Pembayaran
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'id_murid', 'id_murid');
    }

    // Relasi dengan Pembayaran terbaru
    public function pembayaranTerbaru()
    {
        return $this->hasOne(Pembayaran::class, 'id_murid', 'id_murid')->latestOfMany();
    }

    // Relasi dengan Kelas (jika ada id_kelas)
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }
}
