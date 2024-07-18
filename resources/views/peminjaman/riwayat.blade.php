@extends('layouts.layout')

@section('content')
    <div class="container border-4 border-radius-xl">
        <h4 class="text-center">Riwayat Peminjaman</h4>

        @if (session('success'))
            <div class="alert alert-success text-white">
                {{ session('success') }}
            </div>
        @elseif (session('rejected'))
            <div class="alert alert-danger text-white">
                {{ session('rejected') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif
        <style>
            .alert {
                color: white !important;
            }
        </style>

        <!-- filter-->

        <form method="GET" action="{{ route('peminjaman.riwayat') }}">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="bulan">Pilih Bulan:</label>
                        <input type="month" id="bulan" name="bulan" class="form-control"
                            value="{{ $bulan }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <!-- Assuming 'export_excel' is your route name for exporting to Excel -->
                    <a href="{{ route('peminjaman.export_excel', ['bulan' => $bulan]) }}"
                        class="ms-auto btn btn-success">Export to
                        Excel</a>
                </div>
            </div>
        </form>

        {{-- riwayat admin  --}}
        <div class="card p-3 wrap-text">
            <div class="table-responsive">
                <table class="table align-items-center mb-0 text-dark" id="peminjamanTable" style="width: 150px;">
                    <thead>
                        <tr>
                            <th style="color: black;"
                                class="text-center text-uppercase text-xs font-weight-bolder opacity-7">
                                Nama
                                Peminjam</th>
                            <th style="color: black;"
                                class="text-center text-uppercase text-xs font-weight-bolder opacity-7">Tim
                                Kerja</th>
                            <th style="color: black;"
                                class="text-center text-uppercase text-xs font-weight-bolder opacity-7">
                                Jenis Kendaraan</th>
                            <th style="color: black;"
                                class="text-center text-uppercase text-xs font-weight-bolder opacity-7">
                                Kendaraan</th>
                            <th style="color: black;"
                                class="text-center text-uppercase text-xs font-weight-bolder opacity-7">
                                Butuh Driver</th>
                            <th style="color: black;"
                                class="text-center text-uppercase text-xs font-weight-bolder opacity-7">
                                Driver</th>
                            <th style="color: black;"
                                class="text-center text-uppercase text-xs font-weight-bolder opacity-7">Tgl
                                Pinjam</th>
                            <th style="color: black;"
                                class="text-center text-uppercase text-xs font-weight-bolder opacity-7">
                                Status</th>
                            <th style="color: black;"
                                class="text-center text-uppercase text-xs font-weight-bolder opacity-7">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($peminjamanKendaraans as $peminjaman)
                            <tr>
                                <td>{{ $peminjaman->nama_peminjam }}</td>
                                <td class="wrap-text">{{ $peminjaman->timKerja->nama ?? 'N/A' }}</td>
                                <td>{{ $peminjaman->jenis_kendaraan }}</td>
                                <td>
                                    @if ($peminjaman->kendaraan)
                                        {{ $peminjaman->kendaraan->nama_kendaraan }}
                                        {{ $peminjaman->kendaraan->nomor_polisi }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $peminjaman->driver_required }}</td>
                                <td>{{ $peminjaman->driver ? $peminjaman->driver->nama_driver : '-' }}</td>
                                <td>{{ $peminjaman->tanggal_peminjaman }}

                                <td>
                                    @if ($peminjaman->status == 'pending')
                                        <span class="badge bg-warning">{{ $peminjaman->status }}</span>
                                    @elseif ($peminjaman->status == 'Rejected')
                                        <span class="badge bg-primary">{{ $peminjaman->status }}</span>
                                    @elseif($peminjaman->status == 'Dibatalkan')
                                        <span class="badge bg-danger">{{ $peminjaman->status }}</span>
                                    @else
                                        <span class="badge bg-success">{{ $peminjaman->status }}</span>
                                    @endif
                                </td>

                                <td>
                                    <a href="#" class="btn btn-info" data-bs-toggle="modal"
                                        data-bs-target="#detailModal{{ $peminjaman->id }}">
                                        Detail
                                    </a>
                                    @if (Auth::user()->role == 'admin' && ($peminjaman->status == 'pending' || $peminjaman->status == 'Approved'))
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#confirmCancelModal{{ $peminjaman->id }}">
                                            Batal
                                        </button>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $peminjaman->id }}">
                                            Edit
                                        </button>
                                    @endif

                                </td>
                                {{-- aksi admin  --}}
                                <div class="modal fade" id="confirmCancelModal{{ $peminjaman->id }}" tabindex="-1"
                                    aria-labelledby="confirmCancelModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmCancelModalLabel">Konfirmasi
                                                    Pembatalan Peminjaman</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin membatalkan peminjaman ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tidak</button>
                                                <form action="{{ route('peminjaman.batal', $peminjaman->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="detailModal{{ $peminjaman->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-info">
                                                <h5 class="modal-title text-white" id="exampleModalLabel">Detail
                                                    Peminjaman Kendaraan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3 row ">
                                                                <label for="nama_peminjam"
                                                                    class="col-sm-8 col-form-label"><strong>Nama
                                                                        Peminjam:</strong></label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control "
                                                                        id="nama_peminjam"
                                                                        value="{{ $peminjaman->nama_peminjam }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="jenis_kendaraan"
                                                                    class="col-sm-8 col-form-label"><strong>Jenis
                                                                        Kendaraan:</strong></label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control"
                                                                        id="jenis_kendaraan"
                                                                        value="{{ $peminjaman->jenis_kendaraan }}"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="driver"
                                                                    class="col-sm-8 col-form-label"><strong>Kendaraan
                                                                        :</strong></label>
                                                                <div class="col-sm-8">
                                                                    @if ($peminjaman->kendaraan)
                                                                        <input type="text" class="form-control"
                                                                            id="driver"
                                                                            value="{{ $peminjaman->kendaraan->nama_kendaraan }}"
                                                                            readonly>
                                                                    @else
                                                                        <input type="text" class="form-control"
                                                                            id="driver" value="Tanpa Driver" readonly>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="keperluan"
                                                                    class="col-sm-8 col-form-label"><strong>Keperluan:</strong></label>
                                                                <div class="col-sm-8">
                                                                    <textarea class="form-control" id="keperluan" readonly>{{ $peminjaman->keperluan }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="driver_required"
                                                                    class="col-sm-8 col-form-label"><strong>Butuh
                                                                        Driver:</strong></label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control"
                                                                        id="driver_required"
                                                                        value="{{ $peminjaman->driver_required }}"
                                                                        readonly>
                                                                </div>
                                                                <div class="mb-3 row">
                                                                    <label for="no_telp"
                                                                        class="col-sm-8 col-form-label"><strong>No
                                                                            Telp:</strong></label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control"
                                                                            id="no_telp"
                                                                            value="{{ $peminjaman->no_telp }}" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="driver"
                                                                    class="col-sm-8 col-form-label"><strong>Driver:</strong></label>
                                                                <div class="col-sm-8">
                                                                    @if ($peminjaman->driver)
                                                                        <input type="text" class="form-control"
                                                                            id="driver"
                                                                            value="{{ $peminjaman->driver->nama_driver }}"
                                                                            readonly>
                                                                    @else
                                                                        <input type="text" class="form-control"
                                                                            id="driver" value="Tanpa Driver" readonly>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3 row">
                                                                <label for="tujuan"
                                                                    class="col-sm-8 col-form-label"><strong>Tujuan
                                                                        :</strong></label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control"
                                                                        id="tujuan" value="{{ $peminjaman->tujuan }}"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="tanggal_peminjaman"
                                                                    class="col-sm-8 col-form-label"><strong>Tanggal
                                                                        Peminjaman:</strong></label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control"
                                                                        id="tanggal_peminjaman"
                                                                        value="{{ $peminjaman->tanggal_peminjaman }}"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="jam_peminjaman"
                                                                    class="col-sm-8 col-form-label"><strong>Jam
                                                                        Peminjaman:</strong></label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control"
                                                                        id="jam_peminjaman"
                                                                        value="{{ $peminjaman->jam_peminjaman }}"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="tanggal_pengembalian"
                                                                    class="col-sm-8 col-form-label"><strong>Tanggal
                                                                        Pengembalian:</strong></label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control"
                                                                        id="tanggal_pengembalian"
                                                                        value="{{ $peminjaman->tanggal_pengembalian }}"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="jam_pengembalian"
                                                                    class="col-sm-8 col-form-label"><strong>Jam
                                                                        Pengembalian:</strong></label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control"
                                                                        id="jam_pengembalian"
                                                                        value="{{ $peminjaman->jam_pengembalian }}"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="status"
                                                                    class="col-sm-8 col-form-label"><strong>Status:</strong></label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control"
                                                                        id="status" value="{{ $peminjaman->status }}"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                            @if (Auth::user()->role == 'admin')
                                                                @if ($peminjaman->status == 'pending')
                                                                    <form
                                                                        action="{{ route('peminjaman.approve', $peminjaman->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <div class="mb-3">
                                                                            <label for="kendaraan_id"
                                                                                class="form-label">Pilih Kendaraan</label>
                                                                            <select name="kendaraan_id" id="kendaraan_id"
                                                                                class="form-select" required>
                                                                                <option value="">Pilih Kendaraan
                                                                                </option>
                                                                                @foreach ($kendaraans as $kendaraan)
                                                                                    @if ($peminjaman->jenis_kendaraan == 'Sepeda Motor' && $kendaraan->tipe_kendaraan == 'Motor')
                                                                                        <option
                                                                                            value="{{ $kendaraan->id }}">
                                                                                            {{ $kendaraan->nama_kendaraan }}
                                                                                            {{ $kendaraan->nomor_polisi }}
                                                                                        </option>
                                                                                    @elseif($peminjaman->jenis_kendaraan == 'Mobil' && $kendaraan->tipe_kendaraan == 'Mobil')
                                                                                        <option
                                                                                            value="{{ $kendaraan->id }}">
                                                                                            {{ $kendaraan->nama_kendaraan }}
                                                                                            {{ $kendaraan->nomor_polisi }}
                                                                                        </option>
                                                                                    @endif
                                                                                @endforeach
                                                                                @if ($peminjaman->kendaraan == null)
                                                                                    <option value="" selected>Belum
                                                                                        Ditentukan Admin</option>
                                                                                @endif
                                                                            </select>
                                                                        </div>

                                                                        @if ($peminjaman->driver_required == 'Ya')
                                                                            <div class="mb-3">
                                                                                <label for="driver_option"
                                                                                    class="form-label">Pilih atau Masukkan
                                                                                    Driver</label>
                                                                                <select name="driver_option"
                                                                                    id="driver_option" class="form-select"
                                                                                    onchange="toggleDriverInput()">
                                                                                    <option value="">Pilih Driver
                                                                                    </option>
                                                                                    @foreach ($drivers as $driver)
                                                                                        <option
                                                                                            value="{{ $driver->id }}">
                                                                                            {{ $driver->nama_driver }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                    <option value="manual">Masukkan Driver
                                                                                        Secara Manual</option>
                                                                                </select>
                                                                            </div>

                                                                            <div class="mb-3" id="manual_driver_input"
                                                                                style="display: none;">
                                                                                <label for="manual_driver"
                                                                                    class="form-label">Nama Driver</label>
                                                                                <input type="text" name="manual_driver"
                                                                                    id="manual_driver"
                                                                                    class="form-control"
                                                                                    placeholder="Masukkan Nama Driver">
                                                                                <label for="manual_no_telp"
                                                                                    class="form-label mt-2">No.
                                                                                    Telepon</label>
                                                                                <input type="text"
                                                                                    name="manual_no_telp"
                                                                                    id="manual_no_telp"
                                                                                    class="form-control"
                                                                                    placeholder="Masukkan No. Telepon (Opsional)">
                                                                            </div>
                                                                        @endif

                                                                        <button type="submit"
                                                                            class="btn btn-success">Diterima</button>
                                                                    </form>

                                                                    <form
                                                                        action="{{ route('peminjaman.reject', $peminjaman->id) }}"
                                                                        method="POST" style="display:inline;">
                                                                        @csrf
                                                                        <button type="submit"
                                                                            class="btn btn-danger">Ditolak</button>
                                                                    </form>
                                                                @endif
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="editModal{{ $peminjaman->id }}" tabindex="-1"
                                    aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Edit Peminjaman</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('riwayat.update', $peminjaman->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="kendaraan_id" class="form-label">Pilih
                                                            Kendaraan</label>
                                                        <select name="kendaraan_id" id="kendaraan_id"
                                                            class="form-select">
                                                            <option value="">Pilih Kendaraan</option>
                                                            @foreach ($kendaraans as $kendaraan)
                                                                @if ($peminjaman->jenis_kendaraan == 'Sepeda Motor' && $kendaraan->tipe_kendaraan == 'Motor')
                                                                    <option value="{{ $kendaraan->id }}"
                                                                        {{ $peminjaman->kendaraan_id == $kendaraan->id ? 'selected' : '' }}>
                                                                        {{ $kendaraan->nama_kendaraan }}
                                                                        {{ $kendaraan->nomor_polisi }}
                                                                    </option>
                                                                @elseif($peminjaman->jenis_kendaraan == 'Mobil' && $kendaraan->tipe_kendaraan == 'Mobil')
                                                                    <option value="{{ $kendaraan->id }}"
                                                                        {{ $peminjaman->kendaraan_id == $kendaraan->id ? 'selected' : '' }}>
                                                                        {{ $kendaraan->nama_kendaraan }}
                                                                        {{ $kendaraan->nomor_polisi }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @if ($peminjaman->driver_required == 'Ya')
                                                        <div class="mb-3">
                                                            <label for="driver_id" class="form-label">Pilih Driver</label>
                                                            <select name="driver_id" id="driver_id" class="form-select">
                                                                <option value="">Pilih Driver</option>
                                                                @foreach ($drivers as $driver)
                                                                    <option value="{{ $driver->id }}"
                                                                        {{ $peminjaman->driver_id == $driver->id ? 'selected' : '' }}>
                                                                        {{ $driver->nama_driver }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#peminjamanTable').DataTable();
        });
    </script>
    <script>
        function toggleDriverInput() {
            const driverOption = document.getElementById('driver_option');
            const manualDriverInput = document.getElementById('manual_driver_input');
            manualDriverInput.style.display = driverOption.value === 'manual' ? 'block' : 'none';
        }
    </script>
@endpush
