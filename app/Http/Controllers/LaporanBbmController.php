<?php

namespace App\Http\Controllers;

use App\Models\LaporanBbm;
use App\Models\Kendaraan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;

class LaporanBbmController extends Controller
{
    public function index(Request $request)
    {
        $laporan = LaporanBbm::with('kendaraan');
        $title = 'Laporan BBM';
        // Initialize variables
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        // Filter berdasarkan bulan jika nilai bulan dan tahun diberikan
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $laporan->whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulan);
        }

        $laporan = $laporan->get();
        $totalPengeluaran = $laporan->sum('harga');

        return view('laporan_bbm.index', compact('laporan', 'totalPengeluaran', 'bulan', 'tahun', 'title'));
    }

    public function cetakPdf($bulan, $tahun)
    {
        $laporan = LaporanBbm::with('kendaraan')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->get();

        $totalPengeluaran = $laporan->sum('harga');

        $bulan = (int) $bulan;

        // Menggunakan Carbon untuk mendapatkan nama bulan dalam bahasa Indonesia
        $carbonDate = Carbon::createFromDate($tahun, $bulan, 1);
        $bulanNama = $carbonDate->locale('id')->translatedFormat('F');

        // Load view pdf.blade.php
        $html = view('laporan_bbm.pdf', compact('laporan', 'totalPengeluaran', 'bulanNama', 'tahun'))->render();

        // Setup Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // Render PDF
        $dompdf->render();

        // Download PDF dengan nama file laporan_bbm_bulan_tahun.pdf
        return $dompdf->stream('laporan_bbm_' . $bulan . '_' . $tahun . '.pdf');
    }

    public function create()
    {
        $kendaraan = Kendaraan::all();
        $title = 'Laporan BBM';
        return view('laporan_bbm.create', compact('kendaraan', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kendaraan_id' => 'required|exists:kendaraanS,id',
            'liter' => 'required|numeric',
            'bukti_pembelian' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'harga' => 'required|numeric',
        ]);

        // Mengunggah gambar
        $buktiPembelianPath = $request->file('bukti_pembelian')->store('bukti_pembelian', 'public');

        LaporanBbm::create([
            'tanggal' => $request->tanggal,
            'kendaraan_id' => $request->kendaraan_id,
            'liter' => $request->liter,
            'bukti_pembelian' => $buktiPembelianPath,
            'harga' => $request->harga,
        ]);

        return redirect()->route('laporan_bbm.index')->with('success', 'Laporan BBM berhasil ditambahkan');
    }

    public function edit($id)
    {
        $laporan = LaporanBbm::findOrFail($id);
        $kendaraan = Kendaraan::all();
        $title = 'Laporan BBM';
        return view('laporan_bbm.edit', compact('laporan', 'kendaraan', 'title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kendaraan_id' => 'required|exists:kendaraanS,id',
            'liter' => 'required|numeric',
            'harga' => 'required|numeric',
        ]);

        $laporan = LaporanBbm::findOrFail($id);

        // Update hanya jika ada gambar yang diunggah
        if ($request->hasFile('bukti_pembelian')) {
            $request->validate([
                'bukti_pembelian' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Menghapus gambar lama
            Storage::disk('public')->delete($laporan->bukti_pembelian);

            // Mengunggah gambar baru
            $buktiPembelianPath = $request->file('bukti_pembelian')->store('bukti_pembelian', 'public');
            $laporan->bukti_pembelian = $buktiPembelianPath;
        }

        $laporan->tanggal = $request->tanggal;
        $laporan->kendaraan_id = $request->kendaraan_id;
        $laporan->liter = $request->liter;
        $laporan->harga = $request->harga;

        $laporan->save();

        return redirect()->route('laporan_bbm.index')->with('success', 'Laporan BBM berhasil diperbarui');
    }

    public function destroy($id)
    {
        $laporan = LaporanBbm::findOrFail($id);
        Storage::disk('public')->delete($laporan->bukti_pembelian); // Menghapus gambar
        $laporan->delete();
        return redirect()->route('laporan_bbm.index')->with('success', 'Laporan BBM berhasil dihapus');
    }
}
