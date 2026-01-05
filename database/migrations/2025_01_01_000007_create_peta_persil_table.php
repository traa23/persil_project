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
        Schema::create('peta_persil', function (Blueprint $table) {
            $table->id('peta_id');
            $table->unsignedBigInteger('persil_id');
            $table->foreign('persil_id')->references('persil_id')->on('persil')->onDelete('cascade');
            $table->longText('geojson')->nullable();
            $table->decimal('panjang_m', 10, 2)->nullable();
            $table->decimal('lebar_m', 10, 2)->nullable();
            $table->string('file_peta')->nullable()->comment('Peta/scan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peta_persil');
    }
};
