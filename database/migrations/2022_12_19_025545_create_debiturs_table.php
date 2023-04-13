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
        Schema::create('debiturs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->text('alamat');
            $table->string('foto')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->bigInteger('no_telp')->unique()->nullable();
            $table->string('no_ktp', 20)->unique()->nullable();
            $table->enum('status', ['aktif', 'nonaktif']);
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
        Schema::dropIfExists('debiturs');
    }
};
