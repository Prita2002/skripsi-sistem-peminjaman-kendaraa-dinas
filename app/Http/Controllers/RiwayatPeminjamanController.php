<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Driver;
use App\Models\PeminjamanKendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PeminjamanKendaraanExport;

class RiwayatPeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $title = 'Riwayat Peminjaman';

        // Ambil nilai bulan dari request
        $bulan = $request->input('bulan');

        // Query berdasarkan role user
        if ($user->role == 'admin') {
            $peminjamanKendaraans = PeminjamanKendaraan::with('timKerja', 'kendaraan', 'driver')
                ->whereIn('status', ['pending', 'Approved', 'Rejected', 'Dibatalkan']);

            // Filter berdasarkan bulan jika ada
            if ($bulan) {
                $peminjamanKendaraans->whereMonth('created_at', date('m', strtotime($bulan)))
                    ->whereYear('created_at', date('Y', strtotime($bulan)));
            }

            $peminjamanKendaraans = $peminjamanKendaraans->get();
        } else {
            $peminjamanKendaraans = PeminjamanKendaraan::where('tim_kerja_id', $user->tim_kerja_id)
                ->whereIn('status', ['Approved', 'Rejected', 'Dibatalkan']);

            // Filter berdasarkan bulan jika ada
            if ($bulan) {
                $peminjamanKendaraans->whereMonth('created_at', date('m', strtotime($bulan)))
                    ->whereYear('created_at', date('Y', strtotime($bulan)));
            }

            $peminjamanKendaraans = $peminjamanKendaraans->get();
        }

        $kendaraans = Kendaraan::all();
        $drivers = Driver::all();

        return view('peminjaman.riwayat', compact('peminjamanKendaraans', 'kendaraans', 'drivers', 'title', 'bulan'));
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'driver_option' => 'nullable|exists:drivers,id',
            'manual_driver' => 'nullable|string|max:255',
            'manual_no_telp' => 'nullable|string|max:15'
        ]);

        $peminjaman = PeminjamanKendaraan::findOrFail($id);

        // Validasi apakah kendaraan sudah dipinjam pada waktu yang sama
        $existingPeminjaman = PeminjamanKendaraan::where('kendaraan_id', $request->kendaraan_id)
            ->where('tanggal_peminjaman', $peminjaman->tanggal_peminjaman)
            ->where('jam_peminjaman', $peminjaman->jam_peminjaman)
            ->where('status', '!=', 'rejected')
            ->exists();

        if ($existingPeminjaman) {
            return redirect()->back()->withErrors(['msg' => 'Kendaraan sudah dipinjam pada waktu tersebut.']);
        }

        // Validasi apakah driver sudah dipilih pada waktu yang sama
        if ($request->driver_option === 'manual') {
            $driver = Driver::create([
                'nama_driver' => $request->manual_driver,
                'no_telp' => $request->manual_no_telp
            ]);
            $driver_id = $driver->id;
        } else {
            $driver_id = $request->driver_option;

            $existingDriver = PeminjamanKendaraan::where('driver_id', $driver_id)
                ->where('tanggal_peminjaman', $peminjaman->tanggal_peminjaman)
                ->where('jam_peminjaman', $peminjaman->jam_peminjaman)
                ->where('status', '!=', 'rejected')
                ->exists();

            if ($existingDriver) {
                return redirect()->back()->withErrors(['msg' => 'Driver sudah dipilih pada waktu tersebut.']);
            }
        }

        $peminjaman->update([
            'kendaraan_id' => $request->kendaraan_id,
            'driver_id' => $driver_id,
            'status' => 'Approved'
        ]);

        return redirect()->route('peminjaman.riwayat')->with('success', 'Peminjaman berhasil disetujui.');
    }


    public function reject(Request $request, $id)
    {
        $peminjaman = PeminjamanKendaraan::findOrFail($id);

        $peminjaman->update(['status' => 'Rejected']);

        return redirect()->route('peminjaman.riwayat')->with('rejected', 'Peminjaman berhasil ditolak.');
    }

    public function batal(Request $request, $id)
    {
        $peminjaman = PeminjamanKendaraan::findOrFail($id);

        // Pastikan hanya peminjaman yang memiliki status 'pending' atau 'Approved' yang dapat dibatalkan
        if ($peminjaman->status == 'pending' || $peminjaman->status == 'Approved' || $peminjaman->role == 'admin') {
            $peminjaman->update(['status' => 'Dibatalkan']);
            return redirect()->route('peminjaman.riwayat')->with('success', 'Peminjaman berhasil dibatalkan.');
        }

        return redirect()->route('peminjaman.riwayat')->with('error', 'Gagal membatalkan peminjaman. Status peminjaman tidak valid.');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'driver_id' => 'nullable|exists:drivers,id',
        ]);

        $peminjaman = PeminjamanKendaraan::findOrFail($id);

        // Validasi apakah kendaraan sudah dipinjam pada waktu yang sama dengan status selain 'rejected'
        $existingPeminjaman = PeminjamanKendaraan::where('kendaraan_id', $request->kendaraan_id)
            ->where('tanggal_peminjaman', $peminjaman->tanggal_peminjaman)
            ->where('jam_peminjaman', $peminjaman->jam_peminjaman)
            ->where('status', '!=', 'rejected')
            ->where('id', '!=', $id) // Exclude current peminjaman
            ->exists();

        if ($existingPeminjaman) {
            return redirect()->back()->withErrors(['msg' => 'Kendaraan sudah dipinjam pada waktu tersebut.']);
        }

        // Validasi apakah driver sudah dipilih pada waktu yang sama dengan status selain 'rejected'
        if ($request->driver_id) {
            $existingDriver = PeminjamanKendaraan::where('driver_id', $request->driver_id)
                ->where('tanggal_peminjaman', $peminjaman->tanggal_peminjaman)
                ->where('jam_peminjaman', $peminjaman->jam_peminjaman)
                ->where('status', '!=', 'rejected')
                ->where('id', '!=', $id) // Exclude current peminjaman
                ->exists();

            if ($existingDriver) {
                return redirect()->back()->withErrors(['msg' => 'Driver sudah dipilih pada waktu tersebut.']);
            }
        }

        $peminjaman->kendaraan_id = $request->kendaraan_id;
        $peminjaman->driver_id = $request->driver_id;
        $peminjaman->save();

        return redirect()->route('peminjaman.riwayat')->with('success', 'Peminjaman berhasil diperbarui.');
    }

    public function exportExcel(Request $request)
    {
        // Ambil nilai bulan dari request
        $bulan = $request->input('bulan');

        // Query untuk mendapatkan data peminjaman sesuai filter
        $peminjamanKendaraans = $this->getFilteredPeminjamanKendaraan($bulan);

        // Ekspor ke Excel
        return Excel::download(new PeminjamanKendaraanExport($peminjamanKendaraans), 'riwayat_peminjaman.xlsx');
    }

    private function getFilteredPeminjamanKendaraan($bulan)
    {
        $user = Auth::user();

        // Query berdasarkan role user
        if ($user->role == 'admin') {
            $peminjamanKendaraans = PeminjamanKendaraan::with('timKerja', 'kendaraan', 'driver')
                ->whereIn('status', ['pending', 'Approved', 'Rejected', 'Dibatalkan']);
        } else {
            $peminjamanKendaraans = PeminjamanKendaraan::where('tim_kerja_id', $user->tim_kerja_id)
                ->whereIn('status', ['Approved', 'Rejected', 'Dibatalkan']);
        }

        // Filter berdasarkan bulan jika ada
        if ($bulan) {
            $peminjamanKendaraans->whereMonth('created_at', date('m', strtotime($bulan)))
                ->whereYear('created_at', date('Y', strtotime($bulan)));
        }


        return $peminjamanKendaraans->get();
    }
}
