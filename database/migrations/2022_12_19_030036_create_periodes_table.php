<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_periode');
            $table->string('keterangan');
            $table->timestamp('tgl_awal_penilaian')->nullable();
            $table->timestamp('tgl_akhir_penilaian')->nullable();
            $table->timestamp('tgl_pengumuman')->nullable();
            $table->enum('status', ['aktif', 'nonaktif']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('periodes');
    }
};
