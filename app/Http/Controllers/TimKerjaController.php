<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PeminjamanKendaraan;
use App\Models\TimKerja;
use App\Models\User;

class TimKerjaController extends Controller
{
    public function index()
    {
        $timKerja = TimKerja::all();
        $title = 'Tim Kerja';
        return view('tim_kerja.index', compact('timKerja', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        TimKerja::create($request->all());

        return redirect()->route('tim_kerja.index')
            ->with('success', 'Tim Kerja Berhasil Ditambahkan.');
    }

    public function update(Request $request, TimKerja $timKerja)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $timKerja->update($request->all());

        return redirect()->route('tim_kerja.index')
            ->with('success', 'Tim Kerja Berhasil Diperbarui.');
    }

    public function destroy(TimKerja $timKerja)
    {
        // Cek apakah tim kerja masih terkait dengan data di tabel lain
        $relatedInPeminjaman = PeminjamanKendaraan::where('tim_kerja_id', $timKerja->id)->exists();
        $relatedInUsers = User::where('tim_kerja_id', $timKerja->id)->exists();

        // Jika ada data terkait, berikan alert error
        if ($relatedInPeminjaman || $relatedInUsers) {
            return back()->with('error', 'Tim Kerja tidak dapat dihapus karena masih terkait dengan data Peminjaman atau Users.');
        }

        // Jika tidak terkait, hapus tim kerja
        $timKerja->delete();

        return redirect()->route('tim_kerja.index')->with('success', 'Tim Kerja Berhasil Dihapus.');
    }
}
