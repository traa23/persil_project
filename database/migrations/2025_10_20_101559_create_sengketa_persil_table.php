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
        Schema::create('sengketa_persil', function (Blueprint $table) {
            $table->bigIncrements('sengketa_id');

            $table->foreignId('persil_id')
                ->constrained('persil', 'persil_id')
                ->cascadeOnDelete();

            $table->string('pihak_1', 150);
            $table->string('pihak_2', 150)->nullable();
            $table->longText('kronologi')->nullable();
            $table->string('status', 100)->nullable();
            $table->longText('penyelesaian')->nullable();

            // Optional evidence file path
            $table->string('file_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sengketa_persil');
    }
};
