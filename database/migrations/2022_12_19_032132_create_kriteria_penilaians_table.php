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
        Schema::create('kriteria_penilaians', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_master_kriteria')->constrained('master_kriteria_penilaians')->cascadeOnDelete();
            $table->foreignUuid('id_periode')->constrained('periodes')->cascadeOnDelete();
            $table->text('keterangan');
            $table->tinyInteger('bobot_kriteria');
            $table->enum('status', ['aktif', 'nonaktif']);
            // $table->enum('is_statis', [1, 0]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kriteria_penilaians');
    }
};
