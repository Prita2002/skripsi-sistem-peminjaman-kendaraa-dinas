<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('laporan_bbm', function (Blueprint $table) {
            $table->dropForeign(['kendaraan_id']);
            $table->foreign('kendaraan_id')->references('id')->on('kendaraans')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('laporan_bbm', function (Blueprint $table) {
            $table->dropForeign(['kendaraan_id']);
            $table->foreign('kendaraan_id')->references('id')->on('kendaraans');
        });
    }
};
