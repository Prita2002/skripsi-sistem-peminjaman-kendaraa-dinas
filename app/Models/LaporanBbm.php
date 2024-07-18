<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanBbm extends Model
{
    use HasFactory;
    protected $table = 'laporan_bbm';
    protected $fillable = ['tanggal', 'kendaraan_id', 'liter', 'bukti_pembelian', 'harga'];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }
}
