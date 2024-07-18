<!-- resources/views/peminjaman/edit.blade.php -->

@extends('layouts.layout')

@section('content')
    <div class="container p-4 bg-gradient-light border border-dark rounded">
        <h4 class="text-center mb-4">Edit Peminjaman Kendaraan</h4>

        @if (session('success'))
            <div class="alert alert-success text-white">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger text-white">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger text-white">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('peminjaman.update', $peminjaman->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="jenis_kendaraan" class="form-label">Jenis Kendaraan</label>
                <select class="form-select border border-dark p-2 @error('jenis_kendaraan') is-invalid @enderror"
                    id="jenis_kendaraan" name="jenis_kendaraan" required>
                    <option value="">Pilih Jenis Kendaraan</option>
                    <option value="Mobil" {{ $peminjaman->jenis_kendaraan == 'Mobil' ? 'selected' : '' }}>Mobil</option>
                    <option value="Sepeda Motor" {{ $peminjaman->jenis_kendaraan == 'Sepeda Motor' ? 'selected' : '' }}>
                        Sepeda Motor</option>
                </select>
                @error('jenis_kendaraan')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="driver_required" class="form-label">Apakah Butuh Driver?</label>
                <select class="form-select border border-dark p-2 @error('driver_required') is-invalid @enderror"
                    id="driver_required" name="driver_required" required>
                    <option value="">Pilih</option>
                    <option value="Ya" {{ $peminjaman->driver_required == 'Ya' ? 'selected' : '' }}>Ya</option>
                    <option value="Tidak" {{ $peminjaman->driver_required == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                </select>
                @error('driver_required')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nama_peminjam" class="form-label">Nama Peminjam</label>
                <input type="text"
                    class="form-control border border-dark p-2 @error('nama_peminjam') is-invalid @enderror"
                    id="nama_peminjam" name="nama_peminjam" value="{{ $peminjaman->nama_peminjam }}" required>
                @error('nama_peminjam')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="input-group input-group-static mb-4">
                <label for="NIP" class="form">NIP</label>
                <input type="text" class="form-control border border-dark p-2 @error('NIP') is-invalid @enderror"
                    id="NIP" name="NIP" value="{{ $peminjaman->NIP }}" required>
                @error('NIP')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="no_telp" class="form-label">Nomor Telepon</label>
                <input type="text" class="form-control border border-dark p-2 @error('no_telp') is-invalid @enderror"
                    id="no_telp" name="no_telp" value="{{ $peminjaman->no_telp }}" required>
                @error('no_telp')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jumlah_personil" class="form-label">Jumlah Personil</label>
                <input type="number"
                    class="form-control border border-dark p-2 @error('jumlah_personil') is-invalid @enderror"
                    id="jumlah_personil" name="jumlah_personil" value="{{ $peminjaman->jumlah_personil }}" required>
                @error('jumlah_personil')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="keperluan" class="form-label">Keperluan</label>
                <textarea class="form-control border border-dark p-2 @error('keperluan') is-invalid @enderror" id="keperluan"
                    name="keperluan" required>{{ $peminjaman->keperluan }}</textarea>
                @error('keperluan')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-group input-group-static mb-4">
                <label for="tujuan" class="form">Tujuan</label>
                <input type="text" class="form-control border border-dark p-2 @error('tujuan') is-invalid @enderror"
                    id="tujuan" name="tujuan" value="{{ $peminjaman->tujuan }}" required>
                @error('tujuan')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tanggal_peminjaman" class="form-label">Tanggal Peminjaman</label>
                <input type="date"
                    class="form-control border border-dark p-2 @error('tanggal_peminjaman') is-invalid @enderror"
                    id="tanggal_peminjaman" name="tanggal_peminjaman" value="{{ $peminjaman->tanggal_peminjaman }}"
                    required>
                @error('tanggal_peminjaman')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jam_peminjaman" class="form-label">Jam Peminjaman</label>
                <input type="time"
                    class="form-control border border-dark p-2 @error('jam_peminjaman') is-invalid @enderror"
                    id="jam_peminjaman" name="jam_peminjaman" value="{{ $peminjaman->jam_peminjaman }}" required>
                @error('jam_peminjaman')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tanggal_pengembalian" class="form-label">Tanggal Pengembalian</label>
                <input type="date"
                    class="form-control border border-dark p-2 @error('tanggal_pengembalian') is-invalid @enderror"
                    id="tanggal_pengembalian" name="tanggal_pengembalian"
                    value="{{ $peminjaman->tanggal_pengembalian }}" required>
                @error('tanggal_pengembalian')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jam_pengembalian" class="form-label">Jam Pengembalian</label>
                <input type="time"
                    class="form-control border border-dark p-2 @error('jam_pengembalian') is-invalid @enderror"
                    id="jam_pengembalian" name="jam_pengembalian" value="{{ $peminjaman->jam_pengembalian }}" required>
                @error('jam_pengembalian')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Peminjaman</button>
            <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
