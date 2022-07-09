<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPermohonan extends Model
{
    use HasFactory;
    protected $table = 'riwayat_permohonan';
    protected $guarded = [];

    public function getTanggalAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

    public function setTanggalAttribute($value)
    {
        $this->attributes['tanggal'] = date('Y-m-d', strtotime($value));
    }

    function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }

    function status_berkas()
    {
        return $this->belongsTo(StatusBerkas::class);
    }

    function status_berkas_latest()
    {
        return $this->hasOne(StatusBerkas::class)->latest();
    }
}
