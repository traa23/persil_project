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
        Schema::table('users', function (Blueprint $table) {
            // Menambah kolom parent_admin_id untuk tracking admin yang membuat admin baru
            $table->unsignedBigInteger('parent_admin_id')->nullable()->after('admin_id');
            $table->foreign('parent_admin_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['parent_admin_id']);
            $table->dropColumn('parent_admin_id');
        });
    }
};
