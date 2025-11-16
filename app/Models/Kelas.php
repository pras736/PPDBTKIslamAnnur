<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_guru',
        'nama_kelas',
        'nama_guru',
    ];

    // Relasi 1:1 dengan Guru
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id_guru');
    }

    // Relasi 1:M dengan Murid (jika ada id_kelas di tabel murids)
    public function murids()
    {
        return $this->hasMany(Murid::class, 'id_kelas', 'id_kelas');
    }
}
