<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemeriksaan_lanjutan_balita', function (Blueprint $table) {
            $table->id();
            $table->foreignId('balita_id')
                ->constrained('balita')
                ->cascadeOnDelete();
            $table->foreignId('bidan_id')
                ->constrained('users');
            $table->date('tanggal_periksa');
            $table->integer('usia_balita');
            $table->double('berat_badan');
            $table->double('tinggi_badan');
            $table->text('keluhan')->nullable();
            $table->double('lingkar_kepala')->nullable();
            $table->string('status_gizi')->nullable();
            $table->string('imunisasi')->nullable();
            $table->string('vitamin_a')->nullable();
            $table->text('catatan_bidan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_lanjutan_balita');
    }
};
