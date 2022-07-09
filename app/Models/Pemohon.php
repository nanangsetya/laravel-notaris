<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemohon extends Model
{
    use HasFactory;
    protected $table = 'pemohon';
    protected $guarded = [];

    function permohonan()
    {
        return $this->hasMany(Permohonan::class);
    }
}
