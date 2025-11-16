<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'gurus';
    protected $primaryKey = 'id_guru';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_akun',
        'NIP',
        'kelas',
    ];

    // Relasi 1:1 dengan Akun
    public function akun()
    {
        return $this->belongsTo(Akun::class, 'id_akun', 'id_akun');
    }

    // Relasi 1:1 dengan Kelas
    public function kelas()
    {
        return $this->hasOne(Kelas::class, 'id_guru', 'id_guru');
    }
}
