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
        Schema::create('dokumen_persil', function (Blueprint $table) {
            $table->bigIncrements('dokumen_id');

            $table->foreignId('persil_id')
                ->constrained('persil', 'persil_id')
                ->cascadeOnDelete();

            $table->string('jenis_dokumen', 100);
            $table->string('nomor', 100)->nullable();
            $table->text('keterangan')->nullable();

            // For media library or manual file path storage, add nullable path
            $table->string('file_path')->nullable();

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
