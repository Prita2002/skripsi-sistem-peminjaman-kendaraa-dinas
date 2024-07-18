<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PeminjamanKendaraan;
use App\Models\Driver;
use App\Models\Kendaraan; // Pastikan model kendaraan sudah diimpor
use Carbon\Carbon;

class LoginDataController extends Controller
{
    public function index(Request $request)
    {
        $title = "Selamat Datang";
        $today = Carbon::today();

        // Data tipe kendaraan untuk dropdown
        $tipeKendaraan = ['Mobil', 'Motor'];

        // Query untuk kendaraan yang dipilih atau semua kendaraan jika tidak ada pilihan
        $kendaraanQuery = Kendaraan::query();
        if ($request->filled('tipe_kendaraan')) {
            $kendaraanQuery->where('tipe_kendaraan', $request->tipe_kendaraan);
        }
        $kendaraan = $kendaraanQuery->get();

        // Query untuk peminjaman data
        $peminjamanData = PeminjamanKendaraan::whereDate('tanggal_peminjaman', $today)->where('status', 'Approved')->get();

        // Ambil semua driver
        $drivers = Driver::all();

        return view('auth.login', compact('peminjamanData', 'drivers', 'tipeKendaraan', 'kendaraan', 'title'));
    }

    public function filterPeminjaman(Request $request)
    {
        $drivers = Driver::select('id', 'nama_driver')->get();
        $tipeKendaraan = ['Mobil', 'Motor']; // Ambil tipe kendaraan secara langsung

        $query = PeminjamanKendaraan::query()
            ->with(['driver', 'kendaraan'])
            ->where('status', 'Approved');

        if ($request->filled('nama_driver')) {
            $query->where('driver_id', $request->nama_driver);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_peminjaman', $request->tanggal);
        }

        if ($request->filled('tipe_kendaraan')) {
            $query->whereHas('kendaraan', function ($q) use ($request) {
                $q->where('tipe_kendaraan', $request->tipe_kendaraan);
            });
        }

        $peminjamanData = $query->get();

        return view('auth.login', compact('peminjamanData', 'drivers', 'tipeKendaraan'));
    }
}
