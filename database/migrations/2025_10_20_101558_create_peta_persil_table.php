<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peta_persil', function (Blueprint $table) {
            $table->bigIncrements('peta_id');

            $table->foreignId('persil_id')
                ->constrained('persil', 'persil_id')
                ->cascadeOnDelete();

            // GeoJSON can be large; store as longText
            $table->longText('geojson')->nullable();
            $table->decimal('panjang_m', 12, 2)->nullable();
            $table->decimal('lebar_m', 12, 2)->nullable();

            // Optional file path for scanned map/media
            $table->string('file_path')->nullable();

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
