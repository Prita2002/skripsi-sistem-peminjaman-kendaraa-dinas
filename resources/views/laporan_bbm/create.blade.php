@extends('layouts.layout')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4">
                <h1 class="mt-3 mb-4">Tambah Laporan BBM</h1>
                <form action="{{ route('laporan_bbm.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="tanggal" class="form-label">Tanggal:</label>
                        <input type="date" id="tanggal" name="tanggal" class="form-control border border-info p-2"
                            required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="kendaraan_id" class="form-label">Nama Kendaraan:</label>
                        <select id="kendaraan_id" name="kendaraan_id" class="form-control border border-info p-2" required>
                            @foreach ($kendaraan as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_kendaraan }} {{ $item->nomor_polisi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="liter" class="form-label">Volume (Liter):</label>
                        <input type="number" id="liter" name="liter" step="0.01"
                            class="form-control border border-info p-2" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="bukti_pembelian" class="form-label">Bukti Pembelian (Gambar):</label>
                        <input type="file" id="bukti_pembelian" name="bukti_pembelian"
                            class="form-control border border-info p-2" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="harga" class="form-label">Harga:</label>
                        <input type="number" id="harga" name="harga" step="0.01"
                            class="form-control border border-info p-2" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-info">Simpan</button>
                        <a href="{{ route('laporan_bbm.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
