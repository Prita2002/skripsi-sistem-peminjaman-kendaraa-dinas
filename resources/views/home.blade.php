@extends('layouts.layout')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            @auth
                @if (auth()->user()->role == 'admin')
                    <!-- Riwayat Peminjaman Pending Card -->
                    <div class="col-xl-4 col-sm-6 mb-xl-5 mb-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">hourglass_empty</i>
                                </div>
                                <div class="text-end pt-1">
                                    <h4 class="mb-0"><a href="{{ route('peminjaman.riwayat') }}">Menunggu
                                            Peminjaman</a></h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <span
                                    class="text-success text-lg font-weight-bolder">{{ $counts['riwayat_pending_count'] }}</span>
                                <p class="mb-0 float-end">Pending</p>
                            </div>
                        </div>
                    </div>

                    <!-- Riwayat Peminjaman Approved Card -->
                    <div class="col-xl-4 col-sm-6 mb-xl-5 mb-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">check_circle</i>
                                </div>
                                <div class="text-end pt-1">
                                    <h4 class="mb-0"><a href="{{ route('peminjaman.riwayat') }}">Peminjaman
                                            Berhasil</a></h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <span
                                    class="text-success text-lg font-weight-bolder">{{ $counts['riwayat_approved_count'] }}</span>
                                <p class="mb-0 float-end">Approved</p>
                            </div>
                        </div>
                    </div>
                    <!-- Data User Card -->
                    <div class="col-xl-4 col-sm-6 mb-xl-5 mb-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">person</i>
                                </div>
                                <div class="text-end pt-1">
                                    <h4 class="mb-0"><a href="{{ route('users.index') }}">Data User</a></h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <span class="text-success text-lg font-weight-bolder">{{ $counts['user_count'] }}</span>
                                <p class="mb-0 float-end">Users</p>
                            </div>
                        </div>
                    </div>
                    <!-- Data Driver Card -->
                    <div class="col-xl-4 col-sm-6 mb-xl-5 mb-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">drive_eta</i>
                                </div>
                                <div class="text-end pt-1">
                                    <h4 class="mb-0"><a href="{{ route('drivers.index') }}">Data Driver</a></h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <span class="text-success text-lg font-weight-bolder">{{ $counts['driver_count'] }}</span>
                                <p class="mb-0 float-end">Drivers</p>
                            </div>
                        </div>
                    </div>
                    <!-- Data Kendaraan Card -->
                    <div class="col-xl-4 col-sm-6 mb-xl-5 mb-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">directions_car</i>
                                </div>
                                <div class="text-end pt-1">
                                    <h4 class="mb-0"><a href="{{ route('kendaraans.index') }}">Data Kendaraan</a></h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <span class="text-success text-lg font-weight-bolder">{{ $counts['kendaraan_count'] }}</span>
                                <p class="mb-0 float-end">Kendaraan</p>
                            </div>
                        </div>
                    </div>
                    <!-- Data Tim Kerja Card -->
                    <div class="col-xl-4 col-sm-6 mb-xl-5 mb-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">group</i>
                                </div>
                                <div class="text-end pt-1">
                                    <h4 class="mb-0"><a href="{{ route('tim_kerja.index') }}">Data Tim Kerja</a></h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <span class="text-success text-lg font-weight-bolder">{{ $counts['tim_kerja_count'] }}</span>
                                <p class="mb-0 float-end">Tim Kerja</p>
                            </div>
                        </div>
                    </div>
                    <!-- Laporan BBM Card -->
                    <div class="col-xl-4 col-sm-6 mb-xl-5 mb-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">local_gas_station</i>
                                </div>
                                <div class="text-end pt-1">
                                    <h4 class="mb-0"><a href="{{ route('laporan_bbm.index') }}">Laporan BBM</a></h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <span class="text-success text-lg font-weight-bolder">{{ $counts['laporan_bbm_count'] }}</span>
                                <p class="mb-0 float-end">Laporan</p>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Peminjaman Pending Card -->
                    <div class="col-xl-4 col-sm-6 mb-xl-5 mb-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">hourglass_empty</i>
                                </div>
                                <div class="text-end pt-1">
                                    <h4 class="mb-0"><a href="{{ route('peminjaman.index') }}">Menunggu Peminjaman</a></h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <span
                                    class="text-success text-lg font-weight-bolder">{{ $counts['peminjaman_pending_count'] }}</span>
                                <p class="mb-0 float-end">Pending</p>
                            </div>
                        </div>
                    </div>
                    <!-- Riwayat Peminjaman Approved Card -->
                    <div class="col-xl-4 col-sm-6 mb-xl-5 mb-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">check_circle</i>
                                </div>
                                <div class="text-end pt-1">
                                    <a href="">
                                        <h4 class="mb-0"><a href="{{ route('peminjaman.riwayat') }}">Peminjaman
                                                Berhasil</a>
                                        </h4>
                                    </a>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <span
                                    class="text-success text-lg font-weight-bolder">{{ $counts['riwayat_approved_count'] }}</span>
                                <p class="mb-0 float-end">Approved</p>
                            </div>
                        </div>
                    </div>
                @endif
            @endauth
        </div>
    </div>
@endsection
