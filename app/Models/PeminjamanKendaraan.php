<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class PeminjamanKendaraan extends Model
{
    use HasFactory;

    protected $dates = ['tanggal_peminjaman', 'tanggal_pengembalian'];

    protected $fillable = [
        'kendaraan_id', 'driver_id', 'tim_kerja_id', 'nama_peminjam', 'NIP', 'no_telp',
        'jumlah_personil', 'keperluan', 'status', 'tanggal_peminjaman', 'jenis_kendaraan', 'driver_required', 'jam_peminjaman',
        'tanggal_pengembalian', 'jam_pengembalian', 'tujuan',
    ];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'tim_kerja_id');
    }

    public function timKerja()
    {
        return $this->belongsTo(TimKerja::class, 'tim_kerja_id');
    }

    // public function getTanggalPeminjamanAttribute($value)
    // {
    //     return Carbon::parse($value);
    // }

    // public function getTanggalPengembalianAttribute($value)
    // {
    //     return $value ? Carbon::parse($value) : null;
    // }

    // // Custom accessors for jam_peminjaman and jam_pengembalian
    // public function getJamPeminjamanAttribute()
    // {
    //     return $this->tanggal_peminjaman ? $this->tanggal_peminjaman->format('H:i:s') : null;
    // }

    // public function getJamPengembalianAttribute()
    // {
    //     return $this->tanggal_pengembalian ? $this->tanggal_pengembalian->format('H:i:s') : null;
    // }
}
