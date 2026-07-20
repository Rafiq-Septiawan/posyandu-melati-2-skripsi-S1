<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ibu_hamil', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ibu');
            $table->string('nik')->unique();
            $table->date('tanggal_lahir');
            $table->string('no_hp')->nullable();
            $table->text('alamat')->nullable();
            $table->integer('gravida')->default(1);
            $table->integer('partus')->default(0);
            $table->integer('abortus')->default(0);
            $table->date('hpht')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ibu_hamil');
    }
};
