<?php

namespace App\Exports;

use App\Models\PeminjamanKendaraan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Carbon;

class PeminjamanKendaraanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $peminjamanKendaraans;

    public function __construct($peminjamanKendaraans)
    {
        $this->peminjamanKendaraans = $peminjamanKendaraans;
    }

    public function collection()
    {
        return $this->peminjamanKendaraans;
    }

    public function headings(): array
    {
        return [
            'Tanggal Pinjam',
            'Nama Peminjam',
            'Tim Kerja',
            'Keperluan',
            'Tujuan',
            'Kendaraan',
            'No Polisi',
            'Status',
            // 'Aksi',  // Assuming 'Aksi' column is not needed in export
        ];
    }

    public function map($peminjamanKendaraan): array
    {
        return [
            $peminjamanKendaraan->tanggal_peminjaman instanceof Carbon ? $peminjamanKendaraan->tanggal_peminjaman->format('Y-m-d H:i:s') : $peminjamanKendaraan->tanggal_peminjaman,
            $peminjamanKendaraan->nama_peminjam,
            $peminjamanKendaraan->timKerja->nama,
            $peminjamanKendaraan->keperluan,
            $peminjamanKendaraan->tujuan,
            $peminjamanKendaraan->kendaraan->nama_kendaraan ?? '-',
            $peminjamanKendaraan->kendaraan->nomor_polisi ?? '-',
            $peminjamanKendaraan->status,
        ];
    }
}
