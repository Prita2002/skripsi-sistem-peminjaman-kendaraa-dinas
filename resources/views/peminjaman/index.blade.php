@extends('layouts.layout')

@section('content')
    <div class="container p-4 border-4 border-radius-xl">
        <h4 class="text-center">Daftar Pengajuan Peminjaman Kendaraan</h4>

        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-3 mx-3 text-white">
                {{ $message }}
            </div>
        @endif
        @if ($message = Session::get('error'))
            <div class="alert alert-danger mt-3 mx-3 text-white">
                {{ $message }}
            </div>
        @endif

        <div class="text-right mb-3">
            <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">Ajukan Peminjaman Kendaraan</a>
        </div>

        <div class="card p-3">
            <div class="table-responsive">
                <table id="peminjamanTable " class="table align-items-center mb-0 text-dark ">
                    <thead>
                        <tr>
                            <th style="color: black;"
                                class="text-center text-uppercase text-xs font-weight-bolder opacity-7">NIP</th>
                            <th style="color: black;"
                                class="text-center text-uppercase text-xs font-weight-bolder opacity-7">Nama Peminjam</th>
                            <th style="color: black;"
                                class="text-center text-uppercase text-xs font-weight-bolder opacity-7">Jenis Kendaraan</th>
                            <th style="color: black;"
                                class="text-center text-uppercase text-xs font-weight-bolder opacity-7">Driver Required</th>
                            <th style="color: black;"
                                class="text-center text-uppercase text-xs font-weight-bolder opacity-7">Keperluan</th>
                            <th style="color: black;"
                                class="text-center text-uppercase text-xs font-weight-bolder opacity-7">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjamanKendaraans as $peminjaman)
                            @if ($peminjaman->status == 'pending')
                                <tr class="wrap-text">
                                    <td class="wrap-text">{{ $peminjaman->NIP }}</td>
                                    <td class="wrap-text">{{ $peminjaman->nama_peminjam }}</td>
                                    <td class="wrap-text">{{ $peminjaman->jenis_kendaraan }}</td>
                                    <td class="wrap-text">{{ $peminjaman->driver_required }}</td>
                                    <td class="wrap-text">{{ $peminjaman->keperluan }}</td>
                                    <td>
                                        <a type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal{{ $peminjaman->id }}">
                                            Detail
                                        </a>

                                        <a href="{{ route('peminjaman.edit', $peminjaman->id) }}"
                                            class="btn btn-warning">Edit</a>
                                        <form action="{{ route('peminjaman.destroy', $peminjaman->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">Hapus</button>
                                        </form>

                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach ($peminjamanKendaraans as $peminjaman)
        <div class="modal fade" id="exampleModal{{ $peminjaman->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header position-sticky-top z-index-sticky">
                        <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Detail Peminjaman Kendaraan</h5>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="detail-NIP" class="form-label">NIP:</label>
                            <input type="text" class="form-control wrap-text" id="detail-NIP" readonly
                                value="{{ $peminjaman->NIP }}">
                        </div>
                        <div class="mb-3">
                            <label for="detail-nama" class="form-label">Nama Peminjam:</label>
                            <input type="text" class="form-control wrap-text" id="detail-nama" readonly
                                value="{{ $peminjaman->nama_peminjam }}">
                        </div>

                        <div class="mb-3">
                            <label for="detail-jenis" class="form-label">Jenis Kendaraan:</label>
                            <input type="text" class="form-control wrap-text" id="detail-jenis" readonly
                                value="{{ $peminjaman->jenis_kendaraan }}">
                        </div>
                        <div class="mb-3">
                            <label for="detail-driver" class="form-label">Driver Required:</label>
                            <input type="text" class="form-control wrap-text" id="detail-driver" readonly
                                value="{{ $peminjaman->driver_required }}">
                        </div>
                        <div class="mb-3">
                            <label for="detail-keperluan" class="form-label">Keperluan:</label>
                            <textarea class="form-control wrap-text" id="detail-keperluan" readonly>{{ $peminjaman->keperluan }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="tujuan" class="form-label">Tujuan</label>
                            <input type="text" class="form-control wrap-text" id="tujuan"
                                value="{{ $peminjaman->tujuan }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="detail-tanggal-peminjaman" class="form-label">Tanggal Peminjaman:</label>
                            <input type="text" class="form-control wrap-text" id="detail-tanggal-peminjaman" readonly
                                value="{{ $peminjaman->tanggal_peminjaman }}">
                        </div>
                        <div class="mb-3">
                            <label for="detail-jam-peminjaman" class="form-label">Jam Peminjaman:</label>
                            <input type="text" class="form-control wrap-text" id="detail-jam-peminjaman" readonly
                                value="{{ $peminjaman->jam_peminjaman }}">
                        </div>
                        <div class="mb-3">
                            <label for="detail-tanggal-pengembalian" class="form-label">Tanggal Pengembalian:</label>
                            <input type="text" class="form-control wrap-text" id="detail-tanggal-pengembalian"
                                readonly value="{{ $peminjaman->tanggal_pengembalian }}">
                        </div>
                        <div class="mb-3">
                            <label for="detail-jam-pengembalian" class="form-label">Jam Pengembalian:</label>
                            <input type="text" class="form-control wrap-text" id="detail-jam-pengembalian" readonly
                                value="{{ $peminjaman->jam_pengembalian }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <style>
        .wrap-text {
            word-wrap: break-word;
            /* Membungkus teks yang panjang */
            white-space: normal;
            /* Memungkinkan teks menjadi multiline */
            overflow-wrap: break-word;
            /* Membungkus kata jika terlalu panjang */
        }
    </style>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#peminjamanTable').DataTable();
        });
    </script>
@endpush
