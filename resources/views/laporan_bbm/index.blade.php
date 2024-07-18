@extends('layouts.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="card p-3">
                <div class="col-md-12 p-3">
                    <h1 class="mt-4">Laporan BBM</h1>
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
                    <form action="{{ route('laporan_bbm.index') }}" method="GET" class="mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bulan">Pilih Bulan:</label>
                                    <select name="bulan" id="bulan" class="form-control">
                                        <option value="01" {{ $bulan == '01' ? 'selected' : '' }}>Januari</option>
                                        <option value="02" {{ $bulan == '02' ? 'selected' : '' }}>Februari</option>
                                        <option value="03" {{ $bulan == '03' ? 'selected' : '' }}>Maret</option>
                                        <option value="04" {{ $bulan == '04' ? 'selected' : '' }}>April</option>
                                        <option value="05" {{ $bulan == '05' ? 'selected' : '' }}>Mei</option>
                                        <option value="06" {{ $bulan == '06' ? 'selected' : '' }}>Juni</option>
                                        <option value="07" {{ $bulan == '07' ? 'selected' : '' }}>Juli</option>
                                        <option value="08" {{ $bulan == '08' ? 'selected' : '' }}>Agustus</option>
                                        <option value="09" {{ $bulan == '09' ? 'selected' : '' }}>September</option>
                                        <option value="10" {{ $bulan == '10' ? 'selected' : '' }}>Oktober</option>
                                        <option value="11" {{ $bulan == '11' ? 'selected' : '' }}>November</option>
                                        <option value="12" {{ $bulan == '12' ? 'selected' : '' }}>Desember</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="tahun">Tahun:</label>
                                    <input type="text" name="tahun" id="tahun" class="form-control"
                                        value="{{ $tahun }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary mt-4">Filter</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <a href="{{ route('laporan_bbm.pdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                        class="btn btn-info mb-3">Unduh Laporan PDF</a>
                    <a href="{{ route('laporan_bbm.create') }}" class="btn btn-primary mb-3">Tambah Laporan BBM</a>
                    <div class="table-responsive">
                        <table class="table table-striped" id="">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal</th>
                                    <th>Nama Kendaraan</th>
                                    <th>Volume(Liter)</th>
                                    <th>Bukti Pembelian</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($laporan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->tanggal }}</td>
                                        <td>
                                            @if ($item->kendaraan)
                                                {{ $item->kendaraan->nama_kendaraan }}
                                                {{ $item->kendaraan->nomor_polisi }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $item->liter }}</td>
                                        <td>
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#imageModal{{ $item->id }}">
                                                <img src="{{ asset('storage/' . $item->bukti_pembelian) }}"
                                                    alt="Bukti Pembelian" class="img-fluid" style="max-width: 200px;">
                                            </a>
                                        </td>
                                        <td>{{ number_format($item->harga, 0, ',', '.') }}</td>
                                        <td>
                                            <a href="{{ route('laporan_bbm.edit', $item->id) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('laporan_bbm.destroy', $item->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="imageModal{{ $item->id }}" tabindex="-1"
                                        aria-labelledby="imageModalLabel{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="imageModalLabel{{ $item->id }}">Bukti
                                                        Pembelian</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <img src="{{ asset('storage/' . $item->bukti_pembelian) }}"
                                                        alt="Bukti Pembelian" class="img-fluid w-100">
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="{{ asset('storage/' . $item->bukti_pembelian) }}" download
                                                        class="btn btn-primary">Download</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <tr class="text-center">
                                    <td colspan="4"></td>
                                    <td><strong>Total Pengeluaran:</strong></td>
                                    <td class="fw-bold text-danger fs-5">Rp
                                        {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                                    <td colspan="1"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#laporanBbm').DataTable();
        });
    </script>
@endpush
