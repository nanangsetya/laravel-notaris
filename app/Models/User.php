<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class User extends Model implements Authenticatable
{
    use HasFactory;
    use \Illuminate\Auth\Authenticatable;

    protected $guarded = [];

    function role()
    {
        return $this->belongsTo(Role::class);
    }

    function permohonan()
    {
        return $this->hasMany(Permohonan::class);
    }
}
