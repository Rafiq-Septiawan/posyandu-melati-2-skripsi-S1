<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemeriksaan_awal_balita', function (Blueprint $table) {
            $table->id();
            $table->foreignId('balita_id')
                ->constrained('balita')
                ->cascadeOnDelete();
            $table->foreignId('kader_id')
                ->constrained('users');
            $table->date('tanggal_periksa');
            $table->integer('usia_balita')->nullable();
            $table->double('berat_badan')->nullable();
            $table->double('tinggi_badan')->nullable();
            $table->text('keluhan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_balita');
    }
};
