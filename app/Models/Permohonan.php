<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    use HasFactory;

    protected $table = 'permohonan';
    protected $guarded = [];

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function jenis_berkas()
    {
        return $this->belongsTo(JenisBerkas::class);
    }

    function pemohon()
    {
        return $this->belongsTo(Pemohon::class);
    }

    function riwayat_permohonan()
    {
        return $this->hasMany(RiwayatPermohonan::class);
    }

    function riwayat_latest()
    {
        return $this->hasOne(RiwayatPermohonan::class)->latest();
    }

    function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }
}
