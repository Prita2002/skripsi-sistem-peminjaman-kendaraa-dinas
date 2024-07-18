<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\PeminjamanKendaraan;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::all();
        $title = 'Driver';
        return view('drivers.index', compact('drivers', 'title'));
    }

    public function create()
    {
        return view('drivers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_driver' => 'required',
            'no_telp' => 'required',
        ]);

        Driver::create($request->all());

        return redirect()->route('drivers.index')->with('success', 'Driver Berhasil Dibuat.');
    }

    public function edit(Driver $driver)
    {
        return view('drivers.edit', compact('driver'));
    }

    public function update(Request $request, Driver $driver)
    {
        $request->validate([
            'nama_driver' => 'required',
            'no_telp' => 'required',
        ]);

        $driver->update($request->all());

        return redirect()->route('drivers.index')->with('success', 'Driver Berhasil Diperbarui.');
    }

    public function destroy($id)
    {
        $driver = Driver::findOrFail($id);

        // Cek apakah driver masih terkait dengan peminjaman kendaraan
        $peminjamanKendaraan = PeminjamanKendaraan::where('driver_id', $driver->id)->exists();

        // Jika driver masih terkait dengan data peminjaman kendaraan, berikan alert error
        if ($peminjamanKendaraan) {
            return back()->with('error', 'Driver tidak dapat dihapus karena masih terkait dengan data peminjaman kendaraan.');
        }

        // Jika tidak terkait, hapus driver secara soft delete
        $driver->delete();

        return redirect()->route('drivers.index')->with('success', 'Driver berhasil dihapus.');
    }
}
