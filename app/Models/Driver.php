<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    protected $fillable = ['nama_driver', 'no_telp'];

    public function peminjamanKendaraans()
    {
        return $this->hasMany(PeminjamanKendaraan::class);
    }
}
