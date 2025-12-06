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
            // Primary key uses a custom name per requirement
            $table->bigIncrements('persil_id');

            // Columns
            $table->string('kode_persil', 50)->unique();

            // Optional relation to users as the owner of the parcel
            $table->foreignId('pemilik_warga_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->decimal('luas_m2', 12, 2)->nullable();
            $table->string('penggunaan', 100)->nullable();
            $table->text('alamat_lahan')->nullable();

            // RT/RW stored as short strings to allow flexible formats
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();

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
