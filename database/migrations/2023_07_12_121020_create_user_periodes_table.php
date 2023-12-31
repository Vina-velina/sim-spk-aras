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
        Schema::create('user_periodes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_debitur')->constrained('debiturs')->cascadeOnDelete();
            $table->foreignUuid('id_periode')->constrained('periodes')->cascadeOnDelete();
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
        Schema::dropIfExists('user_periodes');
    }
};
