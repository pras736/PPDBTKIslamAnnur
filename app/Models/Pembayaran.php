<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';
    protected $primaryKey = 'id_pembayaran';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_murid',
        'bukti_pembayaran',
        'status_pembayaran',
    ];

    // Relasi M:1 dengan Murid
    public function murid()
    {
        return $this->belongsTo(Murid::class, 'id_murid', 'id_murid');
    }
}
