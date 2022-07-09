<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $table = 'pembayaran';
    protected $guarded = [];

    public function getTanggalAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

    function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }

    function status_bayar()
    {
        return $this->belongsTo(StatusBayar::class);
    }
}
