<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('persil', function (Blueprint $table) {
            $table->id('persil_id');
            $table->string('kode_persil')->unique();
            $table->unsignedBigInteger('pemilik_warga_id')->nullable();
            $table->foreign('pemilik_warga_id')->references('id')->on('users')->onDelete('set null');
            $table->decimal('luas_m2', 10, 2)->nullable();
            $table->unsignedBigInteger('jenis_id')->nullable();
            $table->foreign('jenis_id')->references('jenis_id')->on('jenis_penggunaan')->onDelete('set null');
            $table->string('alamat_lahan');
            $table->integer('rt')->nullable();
            $table->integer('rw')->nullable();
            $table->string('foto_persil')->nullable()->comment('Foto bidang/koordinat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persil');
    }
};
