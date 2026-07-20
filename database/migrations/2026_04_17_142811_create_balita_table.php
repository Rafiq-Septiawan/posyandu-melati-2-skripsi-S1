<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('balita', function (Blueprint $table) {
        $table->id();
        $table->foreignId('ibu_hamil_id')->nullable()->constrained('ibu_hamil')->nullOnDelete();
        $table->string('nama_balita');
        $table->string('nik')->nullable();
        $table->date('tanggal_lahir');
        $table->enum('jenis_kelamin',['L','P']);
        $table->string('no_hp_ortu')->nullable();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('balita');
    }
};
