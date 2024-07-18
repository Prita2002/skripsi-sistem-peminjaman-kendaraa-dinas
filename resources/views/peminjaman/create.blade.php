@extends('layouts.layout')

@section('content')
    <div class="container p-4 border-4 border-radius-xl ">
        <h4 class="text-center">Form Peminjaman Kendaraan</h4>
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

        <form method="POST" action="{{ route('peminjaman.store') }}">
            @csrf

            <div class=" mb-3">
                <label for="jenis_kendaraan" class="form">Jenis Kendaraan</label>
                <select class="form-select p-2 @error('jenis_kendaraan') is-invalid @enderror" id="jenis_kendaraan"
                    name="jenis_kendaraan" required>
                    <option value="">Pilih Jenis Kendaraan</option>
                    <option value="Mobil">Mobil</option>
                    <option value="Sepeda Motor">Sepeda Motor</option>
                </select>
                @error('jenis_kendaraan')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class=" mb-3">
                <label for="driver_required" class="form">Apakah Butuh Driver?</label>
                <select class="form-select p-2 @error('driver_required') is-invalid @enderror" id="driver_required"
                    name="driver_required" required>
                    <option value="">Pilih</option>
                    <option value="Ya">Ya</option>
                    <option value="Tidak">Tidak</option>
                </select>
                @error('driver_required')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="input-group input-group-static mb-4">
                <label for="NIP" class="form">NIP</label>
                <input type="text" class="form-control @error('NIP') is-invalid @enderror" id="NIP" name="NIP"
                    value="{{ old('NIP') }}" required>
                @error('NIP')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="input-group input-group-static mb-4">
                <label for="nama_peminjam" class="form">Nama Peminjam</label>
                <input type="text" class="form-control @error('nama_peminjam') is-invalid @enderror" id="nama_peminjam"
                    name="nama_peminjam" value="{{ old('nama_peminjam') }}" required>
                @error('nama_peminjam')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


            <div class="input-group input-group-static mb-4">
                <label for="no_telp" class="form">Nomor Telepon</label>
                <input type="text" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp"
                    name="no_telp" value="{{ old('no_telp') }}" required>
                @error('no_telp')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-group input-group-static mb-4">
                <label for="jumlah_personil" class="form">Jumlah Personil</label>
                <input type="number" class="form-control @error('jumlah_personil') is-invalid @enderror"
                    id="jumlah_personil" name="jumlah_personil" value="{{ old('jumlah_personil') }}" required>
                @error('jumlah_personil')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-group input-group-static mb-4">
                <label for="keperluan" class="form">Keperluan</label>
                <textarea class="form-control @error('keperluan') is-invalid @enderror" id="keperluan" name="keperluan" required>{{ old('keperluan') }}</textarea>
                @error('keperluan')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-group input-group-static mb-4">
                <label for="tujuan" class="form">Tujuan</label>
                <input type="text" class="form-control @error('tujuan') is-invalid @enderror" id="tujuan"
                    name="tujuan" value="{{ old('tujuan') }}" required>
                @error('tujuan')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-group input-group-static  mb-3">
                <label for="tanggal_peminjaman" class="form">Tanggal Peminjaman</label>
                <input type="date" class="form-control @error('tanggal_peminjaman') is-invalid @enderror"
                    id="tanggal_peminjaman" name="tanggal_peminjaman" value="{{ old('tanggal_peminjaman') }}" required>
                @error('tanggal_peminjaman')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-group input-group-static mb-3">
                <label for="jam_peminjaman"class="form">Jam Peminjaman</label>
                <input type="time" class="form-control @error('jam_peminjaman') is-invalid @enderror"
                    id="jam_peminjaman" name="jam_peminjaman" value="{{ old('jam_peminjaman') }}" required>
                @error('jam_peminjaman')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-group input-group-static mb-3">
                <label for="tanggal_pengembalian"class="form">Tanggal Pengembalian</label>
                <input type="date" class="form-control @error('tanggal_pengembalian') is-invalid @enderror"
                    id="tanggal_pengembalian" name="tanggal_pengembalian" value="{{ old('tanggal_pengembalian') }}"
                    required>
                @error('tanggal_pengembalian')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-group input-group-static mb-3">
                <label for="jam_pengembalian"class="form">Jam Pengembalian</label>
                <input type="time" class="form-control @error('jam_pengembalian') is-invalid @enderror"
                    id="jam_pengembalian" name="jam_pengembalian" value="{{ old('jam_pengembalian') }}" required>
                @error('jam_pengembalian')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-info">Ajukan Peminjaman</button>
            <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Kembali</a>

        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jenisKendaraan = document.getElementById('jenis_kendaraan');
            const driverRequired = document.getElementById('driver_required');
            const jumlahPersonil = document.getElementById('jumlah_personil');
            const driverSection = document.getElementById('driver-section');

            function updatePersonilLimit() {
                let maxPersonil = 1;

                if (jenisKendaraan.value === 'Mobil') {
                    maxPersonil = driverRequired.value === 'Ya' ? 7 : 8;
                } else if (jenisKendaraan.value === 'Sepeda Motor') {
                    maxPersonil = driverRequired.value === 'Ya' ? 1 : 2;
                }

                jumlahPersonil.max = maxPersonil;
                jumlahPersonil.value = Math.min(jumlahPersonil.value, maxPersonil);
            }

            function toggleDriverSection() {
                if (driverRequired.value === 'Ya') {
                    driverSection.style.display = 'block';
                } else {
                    driverSection.style.display = 'none';
                }
            }

            jenisKendaraan.addEventListener('change', updatePersonilLimit);
            driverRequired.addEventListener('change', updatePersonilLimit);
            driverRequired.addEventListener('change', toggleDriverSection);

            updatePersonilLimit();
            toggleDriverSection();
        });
    </script>
    <style>
        .container {
            background-color: white;
            /* Light background */
            border-radius: 10px;
            /* Rounded corners */
        }

        h4 {
            margin-bottom: 20px;
            font-weight: bold;
        }

        .form {
            font-weight: bold;
            color: black;
        }


        .btn {
            margin-top: 20px;
        }

        .invalid-feedback {
            color: #dc3545;
            /* Red color for invalid feedback */
        }

        .alert {
            margin-bottom: 20px;
        }

        .form-select,
        .form-control {
            border-radius: 5px;
            /* Rounded input fields */
        }
    </style>

@endsection
