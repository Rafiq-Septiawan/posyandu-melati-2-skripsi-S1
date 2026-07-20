<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemeriksaan_lanjutan_ibu_hamil', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ibu_hamil_id')
                ->constrained('ibu_hamil')
                ->cascadeOnDelete();
            $table->foreignId('bidan_id')
                ->constrained('users');
            $table->date('tanggal_periksa');
            $table->integer('usia_kehamilan');
            $table->double('berat_badan');
            $table->string('tekanan_darah');
            $table->text('keluhan')->nullable();
            $table->string('trimester')->nullable();
            $table->double('lila')->nullable();
            $table->double('tfu')->nullable();
            $table->integer('djj')->nullable();
            $table->text('catatan_bidan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_lanjutan_ibu_hamil');
    }
};
