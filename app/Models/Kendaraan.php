<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;
    protected $fillable = ['nama_kendaraan', 'nomor_polisi', 'tipe_kendaraan'];

    public function peminjamanKendaraans()
    {
        return $this->hasMany(PeminjamanKendaraan::class);
    }
}
