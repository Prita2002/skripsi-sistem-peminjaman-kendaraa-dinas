@extends('layouts.layout')

@section('content')
    <div class="container p-4 bg-gradient-light border-4 border-radius-xl">
        <h4 class="text-center">Edit Laporan BBM</h4>
        <form action="{{ route('laporan_bbm.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="card-header">
                    Edit Laporan BBM
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" id="tanggal" name="tanggal" class="form-control"
                            value="{{ $laporan->tanggal }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="kendaraan_id" class="form-label">Nama Kendaraan</label>
                        <select id="kendaraan_id" name="kendaraan_id" class="form-control" required>
                            @foreach ($kendaraan as $item)
                                <option value="{{ $item->id }}" @if ($item->id == $laporan->kendaraan_id) selected @endif>
                                    {{ $item->nama_kendaraan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="liter" class="form-label">Liter</label>
                        <input type="number" id="liter" name="liter" step="0.01" class="form-control"
                            value="{{ $laporan->liter }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="bukti_pembelian" class="form-label">Bukti Pembelian (Gambar)</label>
                        <input type="file" id="bukti_pembelian" name="bukti_pembelian" class="form-control-file">
                        <img src="{{ asset('storage/' . $laporan->bukti_pembelian) }}" alt="Bukti Pembelian"
                            class="img-fluid mt-2" style="max-width: 200px;">
                    </div>

                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" id="harga" name="harga" step="0.01" class="form-control"
                            value="{{ $laporan->harga }}" required>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('laporan_bbm.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </form>
    </div>
@endsection
