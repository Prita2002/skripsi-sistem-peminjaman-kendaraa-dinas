<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Driver;
use App\Models\PeminjamanKendaraan;
use App\Models\TimKerja;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class PeminjamanKendaraanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $peminjamanKendaraans = PeminjamanKendaraan::where('tim_kerja_id', $user->tim_kerja_id)->get();
        $title = 'Peminjaman';

        return view('peminjaman.index', compact('peminjamanKendaraans', 'title'));
    }
    public function create()
    {
        $user = Auth::user();
        $title = 'Ajukan Peminjaman';
        if ($user) {
            return view('peminjaman.create', compact('user', 'title'));
        } else {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
    }
    public function edit($id)
    {
        $user = Auth::user();
        $title = 'Ajukan Peminjaman';
        $peminjaman = PeminjamanKendaraan::where('id', $id)->where('tim_kerja_id', $user->tim_kerja_id)->firstOrFail();
        $drivers = Driver::all();
        return view('peminjaman.edit', compact('peminjaman', 'drivers', 'title'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Validasi input untuk user
        $request->validate([
            'nama_peminjam' => 'required|string|max:255',
            'NIP' => 'required|numeric|digits_between:1,20',
            'jenis_kendaraan' => 'required|in:Mobil,Sepeda Motor',
            'driver_required' => 'required|in:Ya,Tidak',
            'no_telp' => 'required|string|regex:/^[0-9]{10,15}$/',

            'jumlah_personil' => 'required|integer',
            'keperluan' => 'required|string',
            'tujuan' => 'required|string|max:255',
            'tanggal_peminjaman' => [
                'required',
                'date',
                'after_or_equal:' . Carbon::now()->toDateString(), // Tanggal minimal hari ini
                function ($attribute, $value, $fail) {
                    $maxDate = Carbon::now()->addDays(7)->toDateString();
                    if ($value > $maxDate) {
                        $fail('Tanggal peminjaman maksimal H+7 dari tanggal saat ini.');
                    }
                },
            ],
            'jam_peminjaman' => 'required|date_format:H:i',
            'tanggal_pengembalian' => 'required|date|after_or_equal:tanggal_peminjaman', // Pengembalian tidak boleh sebelum peminjaman
            'jam_pengembalian' => 'required|date_format:H:i',
        ]);

        // Validasi jumlah personil berdasarkan jenis kendaraan dan kebutuhan driver
        if ($request->jenis_kendaraan === 'Mobil') {
            $maxPersonil = $request->driver_required === 'Ya' ? 7 : 8;
        } elseif ($request->jenis_kendaraan === 'Sepeda Motor') {
            $maxPersonil = $request->driver_required === 'Ya' ? 1 : 2;
        }
        $request->validate([
            'jumlah_personil' => 'required|integer|max:' . $maxPersonil,
        ]);

        // Validasi driver_id jika driver diperlukan
        if ($request->driver_required === 'Ya') {
            $request->validate([
                'driver_id' => 'exists:drivers,id',
            ]);
        }

        // Pastikan driver_id hanya disimpan jika memang memerlukan driver
        $driverId = $request->driver_required === 'Ya' ? $request->driver_id : null;

        // Buat objek PeminjamanKendaraan baru dan simpan ke database
        $peminjaman = new PeminjamanKendaraan([
            'tim_kerja_id' => $user->tim_kerja_id,
            'nama_peminjam' => $request->nama_peminjam,
            'NIP' => $request->NIP,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'driver_required' => $request->driver_required,
            'driver_id' => $driverId,
            'no_telp' => $request->no_telp,
            'jumlah_personil' => $request->jumlah_personil,
            'keperluan' => $request->keperluan,
            'tujuan' => $request->tujuan,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'jam_peminjaman' => Carbon::createFromFormat('H:i', $request->jam_peminjaman)->format('H:i:s'),
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'jam_pengembalian' => Carbon::createFromFormat('H:i', $request->jam_pengembalian)->format('H:i:s'),
            'status' => 'pending',
        ]);

        $peminjaman->save();
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman kendaraan berhasil diajukan.');
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $peminjaman = PeminjamanKendaraan::where('id', $id)->where('tim_kerja_id', $user->tim_kerja_id)->firstOrFail();

        $request->validate([
            'nama_peminjam' => 'required|string|max:255',
            'NIP' => 'required|numeric|digits_between:1,20',
            'jenis_kendaraan' => 'required|in:Mobil,Sepeda Motor',
            'driver_required' => 'required|in:Ya,Tidak',
            'no_telp' => 'required|string|regex:/^[0-9]{10,15}$/',
            'jumlah_personil' => 'required|integer',
            'keperluan' => 'required|string',
            'tujuan' => 'required|string|max:255',
            'tanggal_peminjaman' => [
                'required',
                'date',
                'after_or_equal:' . Carbon::now()->toDateString(), // Tanggal minimal hari ini
                function ($attribute, $value, $fail) use ($peminjaman) {
                    $maxDate = Carbon::now()->addDays(7)->toDateString();
                    if ($value > $maxDate && $peminjaman->tanggal_peminjaman != $value) {
                        $fail('Tanggal peminjaman maksimal H+7 dari tanggal saat ini.');
                    }
                },
            ],
            'jam_peminjaman' => 'required|date_format:H:i',
            'tanggal_pengembalian' => 'required|date|after_or_equal:tanggal_peminjaman', // Pengembalian tidak boleh sebelum peminjaman
            'jam_pengembalian' => 'required|date_format:H:i',
        ]);

        if ($request->jenis_kendaraan === 'Mobil') {
            $maxPersonil = $request->driver_required === 'Ya' ? 7 : 8;
        } elseif ($request->jenis_kendaraan === 'Sepeda Motor') {
            $maxPersonil = $request->driver_required === 'Ya' ? 1 : 2;
        }
        $request->validate([
            'jumlah_personil' => 'required|integer|max:' . $maxPersonil,
        ]);

        // Validasi driver_id jika driver diperlukan
        if ($request->driver_required === 'Ya') {
            $request->validate([
                'driver_id' => 'exists:drivers,id',
            ]);
        }

        $driverId = $request->driver_required === 'Ya' ? $request->driver_id : null;

        // Update objek PeminjamanKendaraan
        $peminjaman->update([
            'nama_peminjam' => $request->nama_peminjam,
            'NIP' => $request->NIP,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'driver_required' => $request->driver_required,
            'driver_id' => $driverId,
            'no_telp' => $request->no_telp,
            'jumlah_personil' => $request->jumlah_personil,
            'keperluan' => $request->keperluan,
            'tujuan' => $request->tujuan,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'jam_peminjaman' => $request->jam_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'jam_pengembalian' => $request->jam_pengembalian,
            'status' => $request->status ?? 'pending',
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman kendaraan berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $user = Auth::user();
        $peminjaman = PeminjamanKendaraan::where('id', $id)->where('tim_kerja_id', $user->tim_kerja_id)->firstOrFail();
        $peminjaman->delete();

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman kendaraan berhasil dihapus.');
    }

    public function detail($id)
    {
        $user = Auth::user();
        $peminjaman = PeminjamanKendaraan::where('id', $id)
            ->where('tim_kerja_id', $user->tim_kerja_id)
            ->firstOrFail();

        return view('peminjaman.detail', compact('peminjaman'));
    }
}
