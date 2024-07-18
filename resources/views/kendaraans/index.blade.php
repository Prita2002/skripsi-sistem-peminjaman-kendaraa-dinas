@extends('layouts.layout')

@section('content')
    <div class="container">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="shadow-info border-radius-lg pt-4 pb-3" style="background: #013880">
                    <h6 class="text-white text-capitalize ps-3">Kendaraan</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <a data-bs-toggle="modal" data-bs-target="#addKendaraanModal" class="btn btn-primary mt-3 mx-3">Tambahkan</a>


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

                <div class="card p-3 wrap-text">
                    <div class="table-responsive px-3">
                        <table class="table align-items-center mb-0" id="KendaraanTable">
                            <thead>
                                <tr>
                                    <th style="color:black"
                                        class="text-center text-uppercase text-xs font-weight-bolder opacity-7">No
                                    </th>
                                    <th style="color:black"
                                        class="text-center text-uppercase text-xs font-weight-bolder opacity-7 ps-2">
                                        Nama
                                        Kendaraan</th>
                                    <th style="color:black"
                                        class="text-center text-uppercase text-xs font-weight-bolder opacity-7 ps-2">
                                        Nomor
                                        Polisi</th>
                                    <th style="color:black"
                                        class="text-center text-uppercase text-xs font-weight-bolder opacity-7 ps-2">
                                        Tipe
                                        Kendaraan</th>
                                    <th style="color:black"
                                        class="text-center text-uppercase text-xs font-weight-bolder opacity-7 ps-2">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($kendaraans as $kendaraan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $kendaraan->nama_kendaraan }}</td>
                                        <td>{{ $kendaraan->nomor_polisi }}</td>
                                        <td>{{ $kendaraan->tipe_kendaraan }}</td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <button type="button" class="btn btn-warning me-2" data-bs-toggle="modal"
                                                    data-bs-target="#editKendaraanModal{{ $kendaraan->id }}">Edit</button>
                                                <form action="{{ route('kendaraans.destroy', $kendaraan->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus kendaraan ini secara permanen?')">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        <!-- Modal untuk add kendaraan -->
        <div class="modal fade" id="addKendaraanModal" tabindex="-1" aria-labelledby="addKendaraanModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addKendaraanModalLabel">Tambah Kendaraan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('kendaraans.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3 input-group input-group-static mb-4">
                                <label for="nama_kendaraan" class="form-label">Nama Kendaraan</label>
                                <input type="text" class="form-control" id="nama_kendaraan" name="nama_kendaraan"
                                    required>
                            </div>
                            <div class="mb-3 input-group input-group-static mb-4">
                                <label for="nomor_polisi" class="form-label">Nomor Polisi</label>
                                <input type="text" class="form-control" id="nomor_polisi" name="nomor_polisi" required>
                            </div>
                            <div class="mb-3 input-group input-group-static mb-4">
                                <label for="tipe_kendaraan">Tipe Kendaraan</label>
                                <select class="form-control" id="tipe_kendaraan" name="tipe_kendaraan" required>
                                    <option value="Mobil">Mobil</option>
                                    <option value="Motor">Motor</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal untuk edit kendaraan -->
        @foreach ($kendaraans as $kendaraan)
            <div class="modal fade" id="editKendaraanModal{{ $kendaraan->id }}" tabindex="-1"
                aria-labelledby="editKendaraanModalLabel{{ $kendaraan->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editKendaraanModalLabel{{ $kendaraan->id }}">Edit Kendaraan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('kendaraans.update', $kendaraan->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3 input-group input-group-static mb-4">
                                    <label for="edit_nama_kendaraan{{ $kendaraan->id }}">Nama
                                        Kendaraan</label>
                                    <input type="text" class="form-control"
                                        id="edit_nama_kendaraan{{ $kendaraan->id }}" name="nama_kendaraan"
                                        value="{{ $kendaraan->nama_kendaraan }}" required>
                                </div>
                                <div class="mb-3 input-group input-group-static mb-4">
                                    <label for="edit_nomor_polisi{{ $kendaraan->id }}">Nomor
                                        Polisi</label>
                                    <input type="text" class="form-control"
                                        id="edit_nomor_polisi{{ $kendaraan->id }}" name="nomor_polisi"
                                        value="{{ $kendaraan->nomor_polisi }}" required>
                                </div>
                                <div class="mb-3 input-group input-group-static mb-4">
                                    <label for="edit_tipe_kendaraan{{ $kendaraan->id }}">Tipe
                                        Kendaraan</label>
                                    <select class="form-control" id="edit_tipe_kendaraan{{ $kendaraan->id }}"
                                        name="tipe_kendaraan" required>
                                        <option value="Mobil"
                                            {{ $kendaraan->tipe_kendaraan == 'Mobil' ? 'selected' : '' }}>Mobil</option>
                                        <option value="Motor"
                                            {{ $kendaraan->tipe_kendaraan == 'Motor' ? 'selected' : '' }}>Motor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endsection
    @push('scripts')
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#KendaraanTable').DataTable();
            });
        </script>
    @endpush
