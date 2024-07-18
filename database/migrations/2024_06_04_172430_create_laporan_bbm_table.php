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
        Schema::create('laporan_bbm', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('kendaraan_id')->constrained('kendaraans');
            $table->string('liter');
            $table->string('bukti_pembelian');
            $table->decimal('harga', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_bbm');
    }
};
