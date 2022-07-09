<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusBayar extends Model
{
    use HasFactory;

    protected $table = 'status_bayar';
    protected $guarded = [];

    function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }
}
