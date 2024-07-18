<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>
        Selamat Datang
    </title>
    <!-- Fonts and icons -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.1.0') }}" rel="stylesheet" />
    <style>
        .card-plain {
            position: relative;
            overflow: hidden;
            /* to contain the ::before pseudo-element */
        }

        .card-plain::before {
            content: "";
            position: absolute;
            top: 10%;
            left: 3%;
            bottom: 20%;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('assets/img/logo.png') }}');
            background-size: 86%;
            background-position: center;
            opacity: 0.1;
            z-index: -1;
        }
    </style>

</head>

<body class="bg-gray-200">
    <main class="main-content mt-0">
        <section>
            <div class="container">
                <div class="nav-wrapper position-relative end-0 my-4"
                    style="position: -webkit-sticky; position: sticky; top: 0;z-index: 1000; padding: 10px 0;">
                    <ul class="nav nav-pills nav-fill p-1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-1 active" id="tata-cara-link" href="#tata-cara-section">
                                <span class="material-icons align-middle mb-1">badge</span>
                                Tata Cara Peminjaman
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-1" id="jadwal-driver-link" href="#jadwal-driver-section">
                                <span class="material-icons align-middle mb-1">laptop</span>
                                Jadwal Driver/Peminjaman
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
                            <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center"
                                style="background-image: url('https://pbs.twimg.com/profile_images/1772844545635725312/kPMydaZ3_400x400.jpg'); background-size: cover;">
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
                            <div class="card card-frame card-plain p-2">
                                <div>
                                    <h4 class="font-weight-bolder text-center">Login</h4>
                                    <p class="mb-0 text-center">Enter your username and password to log in</p>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('login') }}" class="text-start">
                                        @csrf
                                        <div class="input-group input-group-static mb-4">
                                            <label>Username</label>
                                            <input id="username" type="text"
                                                class="form-control @error('username') is-invalid @enderror"
                                                name="username" value="{{ old('username') }}" required autofocus>
                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="input-group input-group-static mb-4">
                                            <label>Password</label>
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" required autocomplete="current-password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn bg-gradient-primary w-100 my-4 mb-2">Login</button>
                                        </div>
                                    </form>
                                    <p id="note">
                                        jika username dan password lupa bisa menghubungi tim kerja TU a.n Serin
                                        Setyawan
                                        <a href="https://wa.me/+6281228129648" target="_blank">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg"
                                                alt="WhatsApp" style="width:24px; height:24px; vertical-align:middle;">
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </main>
    {{-- filter peminjaman  --}}
    <section class="container" style="color:black; display: none;" id="jadwal-driver-section">
        <div class="container mt-5">
            <div class="card">
                <div class="card-header">
                    <h2>Filter Peminjaman</h2>
                </div>
                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('filter.peminjaman') }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group input-group input-group-static my-3">
                                    <label for="nama_driver">Nama Driver</label>
                                    <select class="form-control" id="nama_driver" name="nama_driver">
                                        <option value="">Semua Driver</option>
                                        @foreach ($drivers as $driver)
                                            <option value="{{ $driver->id }}"
                                                {{ request('nama_driver') == $driver->id ? 'selected' : '' }}>
                                                {{ $driver->nama_driver }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group input-group input-group-static my-3">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal"
                                        value="{{ request('tanggal') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group input-group input-group-static my-3">
                                    <label for="tipe_kendaraan">Tipe Kendaraan</label>
                                    <select class="form-control" id="tipe_kendaraan" name="tipe_kendaraan"
                                        onchange="this.form.submit()">
                                        <option value="">Semua Tipe</option>
                                        @foreach ($tipeKendaraan as $tipe)
                                            <option value="{{ $tipe }}"
                                                {{ request('tipe_kendaraan') == $tipe ? 'selected' : '' }}>
                                                {{ $tipe }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 align-self-end">
                                <a href="#jadwal-driver-section">
                                    <button type="submit" class="btn btn-primary">Filter</button></a>
                            </div>
                        </div>
                    </form>
                    <!-- End Filter Form -->
                </div>
            </div>
            <hr>
            <div class="card mt-4">
                <div class="card-header">
                    <h2>Hasil Filter Peminjaman</h2>
                </div>
                <div class="card-body text-center">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0 text-dark">
                            <thead>
                                <tr>
                                    <th style="color: black;"
                                        class="text-center text-uppercase text-xs font-weight-bolder opacity-7">Nama
                                        Driver</th>
                                    <th style="color: black;"
                                        class="text-center text-uppercase text-xs font-weight-bolder opacity-7">Tgl
                                        Pinjam</th>
                                    <th style="color: black;"
                                        class="text-center text-uppercase text-xs font-weight-bolder opacity-7">Jam
                                        Pinjam</th>
                                    <th style="color: black;"
                                        class="text-center text-uppercase text-xs font-weight-bolder opacity-7">Tgl
                                        Kembali</th>
                                    <th style="color: black;"
                                        class="text-center text-uppercase text-xs font-weight-bolder opacity-7">Jam
                                        Kembali</th>
                                    <th style="color: black;"
                                        class="text-center text-uppercase text-xs font-weight-bolder opacity-7">Tujuan
                                    </th>
                                    <th style="color: black;"
                                        class="text-center text-uppercase text-xs font-weight-bolder opacity-7">
                                        Kendaraan</th>
                                    <th style="color: black;"
                                        class="text-center text-uppercase text-xs font-weight-bolder opacity-7">Tipe
                                        Kendaraan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($peminjamanData as $peminjaman)
                                    <tr>
                                        <td>{{ $peminjaman->driver ? $peminjaman->driver->nama_driver : '-' }}</td>
                                        <td>{{ $peminjaman->tanggal_peminjaman }}</td>
                                        <td>{{ $peminjaman->jam_peminjaman }}</td>
                                        <td>{{ $peminjaman->tanggal_pengembalian }}</td>
                                        <td>{{ $peminjaman->jam_pengembalian }}</td>
                                        <td>{{ $peminjaman->tujuan }}</td>
                                        <td>
                                            @if ($peminjaman->kendaraan)
                                                {{ $peminjaman->kendaraan->nama_kendaraan }}
                                                {{ $peminjaman->kendaraan->nomor_polisi }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $peminjaman->kendaraan ? $peminjaman->kendaraan->tipe_kendaraan : '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container" style="color:black; display: none;" id="tata-cara-section">
        <div class="procedure-title"
            style="font-weight: bold; text-align: center; margin-top: 20px; margin-bottom: 20px;font-size:40px">
            TATA CARA PEMINJAMAN KENDARAAN DINAS
        </div>
        <div class="procedure-list" style="margin: 0 auto; max-width:80%; font-size:30px">
            <ol>
                <li>Login melalui website kemudian masukkan username dan password dengan benar.
                    Username dan password bisa didapatkan dari admin/tim kerja TU
                </li>
                <li>Pilih menu Form Peminjaman.</li>
                <li>Isi Formulir dengan benar.</li>
                <li>Kemudian Klik "Ajukan Peminjaman".</li>
                <li>Kemudian Admin akan menerima atau menolak pengajuan peminjaman</li>
            </ol>

        </div>
    </section>

    <footer style="margin: 0 auto; text-align: center; color:black;">
        <p class="text-lg">&copy; 2024 Prita Noviana | Universitas Alma Ata</p>
    </footer>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (document.querySelector('.invalid-feedback')) {
                var note = document.getElementById('note');
                note.innerHTML = `
                    Note: If you have forgotten your username and password, you can contact the administrative team on WhatsApp 
                    <a href="https://wa.me/081325702515" target="_blank">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" style="width:24px; height:24px; vertical-align:middle;"> here
                    </a>.
                `;
            }
        });
    </script>

    <!-- Core JS Files -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script>
        document.getElementById('tata-cara-link').addEventListener('click', function() {
            document.getElementById('tata-cara-section').style.display = 'block';
            document.getElementById('jadwal-driver-section').style.display = 'none';
            document.getElementById('tata-cara-link').classList.add('active');
            document.getElementById('jadwal-driver-link').classList.remove('active');
        });

        document.getElementById('jadwal-driver-link').addEventListener('click', function() {
            document.getElementById('tata-cara-section').style.display = 'none';
            document.getElementById('jadwal-driver-section').style.display = 'block';
            document.getElementById('tata-cara-link').classList.remove('active');
            document.getElementById('jadwal-driver-link').classList.add('active');
        });
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assets/js/material-dashboard.min.js?v=3.1.0') }}"></script>
</body>

</html>
