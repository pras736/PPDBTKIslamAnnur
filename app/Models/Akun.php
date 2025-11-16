<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Akun extends Authenticatable
{
    use Notifiable;

    protected $table = 'akuns';
    protected $primaryKey = 'id_akun';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'username',
        'password',
        'password_plain',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Relasi 1:1 dengan Murid (untuk wali murid)
    public function murid()
    {
        return $this->hasOne(Murid::class, 'id_akun', 'id_akun');
    }

    // Relasi 1:1 dengan Guru
    public function guru()
    {
        return $this->hasOne(Guru::class, 'id_akun', 'id_akun');
    }
}
