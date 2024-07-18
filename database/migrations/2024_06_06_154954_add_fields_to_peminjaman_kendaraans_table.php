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
        Schema::table('peminjaman_kendaraans', function (Blueprint $table) {
            $table->time('jam_peminjaman')->nullable();
            $table->date('tanggal_pengembalian')->nullable();
            $table->time('jam_pengembalian')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman_kendaraans', function (Blueprint $table) {
            $table->dropColumn(['jam_peminjaman', 'tanggal_pengembalian', 'jam_pengembalian']);
        });
    }
};
