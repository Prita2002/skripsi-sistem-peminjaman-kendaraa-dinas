<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Models\LaporanBBM;
use App\Models\PeminjamanKendaraan;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::all();
        $title = 'Kendaraan';
        return view('kendaraans.index', compact('kendaraans', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kendaraan' => 'required|string|max:255',
            'nomor_polisi' => 'required|string|max:20|unique:kendaraans,nomor_polisi',
            'tipe_kendaraan' => 'required|in:Mobil,Motor',
        ]);

        Kendaraan::create($request->all());

        return redirect()->route('kendaraans.index')->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kendaraan' => 'required|string|max:255',
            'nomor_polisi' => 'required|string|max:20|unique:kendaraans,nomor_polisi,' . $id,
            'tipe_kendaraan' => 'required|in:Mobil,Motor',
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $kendaraan->update($request->all());

        return redirect()->route('kendaraans.index')->with('success', 'Kendaraan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);

        // Cek apakah kendaraan masih terkait dengan laporan BBM
        $laporanBBM = LaporanBBM::where('kendaraan_id', $kendaraan->id)->exists();

        // Cek apakah kendaraan masih terkait dengan peminjaman kendaraan
        $peminjamanKendaraan = PeminjamanKendaraan::where('kendaraan_id', $kendaraan->id)->exists();

        // Jika kendaraan masih terkait dengan data lain, berikan alert error
        if ($laporanBBM || $peminjamanKendaraan) {
            return back()->with('error', 'Kendaraan tidak dapat dihapus karena masih terkait dengan data laporan BBM atau peminjaman kendaraan.');
        }

        // Jika tidak terkait, hapus kendaraan secara soft delete
        $kendaraan->delete();

        return redirect()->route('kendaraans.index')->with('success', 'Kendaraan berhasil dihapus.');
    }
}
