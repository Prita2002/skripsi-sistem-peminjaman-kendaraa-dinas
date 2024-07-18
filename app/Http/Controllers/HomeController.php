<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeminjamanKendaraan;
use App\Models\Driver;
use App\Models\User;
use App\Models\Kendaraan;
use App\Models\TimKerja;
use App\Models\LaporanBbm;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $title = 'Dashboard';
        if ($user->role == 'admin') {
            // Counts for admin
            $counts = [
                'riwayat_pending_count' => PeminjamanKendaraan::where('status', 'pending')->count(),
                'riwayat_approved_count' => PeminjamanKendaraan::where('status', 'approved')->count(),
                'user_count' => User::count(),
                'driver_count' => Driver::count(),
                'kendaraan_count' => Kendaraan::count(),
                'tim_kerja_count' => TimKerja::count(),
                'laporan_bbm_count' => LaporanBbm::count(),
            ];
        } else {
            // Counts for user
            $counts = [
                'peminjaman_pending_count' => PeminjamanKendaraan::where('tim_kerja_id', $user->tim_kerja_id)
                    ->where('status', 'pending')->count(),
                'riwayat_approved_count' => PeminjamanKendaraan::where('tim_kerja_id', $user->tim_kerja_id)
                    ->where('status', 'approved')->count(),
            ];
        }

        return view('home', compact('counts', 'title'));
    }
}
