<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\PeminjamanKendaraanController;
use App\Http\Controllers\RiwayatPeminjamanController;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\CheckUserRole;
use App\Http\Controllers\TimKerjaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanBbmController;
use App\Http\Controllers\Auth\LoginDataController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\ProfileController;

Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Gunakan rute ini untuk halaman login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);

// Gunakan rute ini untuk halaman utama (beranda)
Route::get('/', [LoginDataController::class, 'index'])->name('welcome');

Route::get('/login', [LoginDataController::class, 'index'])->name('login');
Route::get('/filter-peminjaman', [LoginDataController::class, 'filterPeminjaman'])->name('filter.peminjaman');
// Rute untuk riwayat peminjaman
Route::get('/riwayat', [RiwayatPeminjamanController::class, 'index'])->name('peminjaman.riwayat');
Route::post('/peminjaman/{id}/batal', [RiwayatPeminjamanController::class, 'batal'])->name('peminjaman.batal');
Route::get('/riwayat-peminjaman/export-excel', [RiwayatPeminjamanController::class, 'exportExcel'])->name('peminjaman.export_excel');


// Rute peminjaman hanya dapat diakses oleh user dengan middleware CheckUserRole
Route::middleware([CheckUserRole::class])->group(function () {
    Route::resource('peminjaman', PeminjamanKendaraanController::class);
    Route::get('/peminjaman/{id}/detail', [PeminjamanKendaraanController::class, 'detail'])
        ->name('peminjaman.detail');
});

// Rute yang dilindungi oleh middleware check role untuk admin
Route::middleware([CheckRole::class])->group(function () {
    Route::post('/peminjaman/{id}/approve', [RiwayatPeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::put('/peminjaman/update/{id}', [RiwayatPeminjamanController::class, 'update'])->name('riwayat.update');
    Route::post('/peminjaman/{id}/reject', [RiwayatPeminjamanController::class, 'reject'])->name('peminjaman.reject'); // Updated to POST
    Route::resource('drivers', DriverController::class);
    Route::resource('kendaraans', KendaraanController::class);
    Route::resource('users', UserController::class);
    Route::resource('tim_kerja', TimKerjaController::class);
    Route::resource('laporan_bbm', LaporanBbmController::class);
    Route::get('/laporan_bbm/pdf/{bulan}/{tahun}', [LaporanBbmController::class, 'cetakPdf'])->name('laporan_bbm.pdf');
    // Route::resource('data', DataController::class);
});
