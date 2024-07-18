<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjaman_kendaraans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kendaraan_id')->nullable()->constrained('kendaraans');
            $table->foreignId('driver_id')->nullable()->constrained('drivers');
            $table->foreignId('tim_kerja_id')->nullable()->constrained('tim_kerja')->onDelete('set null');
            $table->string('nama_peminjam');
            $table->string('no_telp');
            $table->integer('jumlah_personil');
            $table->text('keperluan');
            $table->string('status')->default('pending');
            $table->date('tanggal_peminjaman');
            $table->string('jenis_kendaraan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_kendaraans');
    }
};
