<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Landingpage</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Styles -->

</head>

<body class="font-sans antialiased background-color: white; color: black;">
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                    <div class="flex lg:justify-center lg:col-start-2">
                        <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                            <a href="https://laravel.com/docs" id="docs-card" class="">
                            </a>
                        </div>
                    </div>
                    @if (Route::has('login'))
                        <nav class="-mx-3 flex flex-1 justify-end">
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    Log in
                                </a>
                            @endauth
                        </nav>
                    @endif
                </header>
                <div class="nav-wrapper position-relative end-0">
                    <ul class="nav nav-pills nav-fill p-1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#profile-tabs-icons"
                                role="tab" aria-controls="preview" aria-selected="true">
                                <span class="material-icons align-middle mb-1">
                                    badge
                                </span>
                                My Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#dashboard-tabs-icons"
                                role="tab" aria-controls="code" aria-selected="false">
                                <span class="material-icons align-middle mb-1">
                                    laptop
                                </span>
                                Dashboard
                            </a>
                        </li>
                    </ul>
                </div>

                <main class="mt-6">
                    <div class="logo">
                    </div>
                    <div class="container">

                        <div class="welcome-message">
                            Selamat datang di Pengajuan Peminjaman Kendaraan Dinas Operasional<br>
                            LLDIKTI Wilayah V Yogyakarta
                        </div>
                        <div class="procedure-title">
                            TATA CARA PEMINJAMAN KENDARAAN DINAS
                        </div>
                        <div class="procedure-list">
                            <ol>
                                <li>Login melalui website kemusian masukkan username dan password dengan benar.</li>
                                <li>Pilih menu Form Peminjaman.</li>
                                <li>Isi Formulir dengan benar.</li>
                                <li>Kemudian Klik "Ajukan Peminjaman".</li>
                                <li>Kemudian Admin akan menerima atau menolak pengajuan peminjaman</li>
                            </ol>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>

</html>
