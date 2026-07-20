<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemeriksaan_awal_ibu_hamil', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ibu_hamil_id')
                ->constrained('ibu_hamil')
                ->cascadeOnDelete();
            $table->foreignId('kader_id')
                ->constrained('users');
            $table->date('tanggal_periksa');
            $table->integer('usia_kehamilan')->nullable();
            $table->double('berat_badan')->nullable();
            $table->string('tekanan_darah')->nullable();
            $table->text('keluhan')->nullable();
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_ibu_hamil');
    }
};
