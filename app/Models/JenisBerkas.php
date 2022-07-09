<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBerkas extends Model
{
    use HasFactory;

    protected $table = 'jenis_berkas';
    protected $guarded = [];

    function permohonan()
    {
        return $this->hasMany(Permohonan::class);
    }
}
