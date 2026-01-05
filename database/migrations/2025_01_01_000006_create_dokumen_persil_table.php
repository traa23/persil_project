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
        Schema::create('dokumen_persil', function (Blueprint $table) {
            $table->id('dokumen_id');
            $table->unsignedBigInteger('persil_id');
            $table->foreign('persil_id')->references('persil_id')->on('persil')->onDelete('cascade');
            $table->string('jenis_dokumen');
            $table->string('nomor')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('file_dokumen')->nullable()->comment('File dokumen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_persil');
    }
};
