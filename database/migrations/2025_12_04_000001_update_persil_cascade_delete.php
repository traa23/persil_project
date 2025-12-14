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
        Schema::table('persil', function (Blueprint $table) {
            // Drop existing foreign key first
            $table->dropForeign(['pemilik_warga_id']);

            // Add new foreign key with cascade delete
            $table->foreign('pemilik_warga_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('persil', function (Blueprint $table) {
            $table->dropForeign(['pemilik_warga_id']);

            // Restore old foreign key
            $table->foreign('pemilik_warga_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }
};
