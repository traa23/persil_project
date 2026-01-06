<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations - Sync dengan struktur persiladmin.sql
     */
    public function up(): void
    {
        // 1. Create media table (universal file storage)
        Schema::create('media', function (Blueprint $table) {
            $table->id('media_id');
            $table->string('ref_table'); // 'persil', 'dokumen_persil', 'sengketa_persil', etc.
            $table->unsignedBigInteger('ref_id');
            $table->string('file_url');
            $table->string('caption')->nullable();
            $table->string('mime_type')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['ref_table', 'ref_id']);
        });

        // 2. Update persil table - ganti jenis_id dengan penggunaan (varchar)
        Schema::table('persil', function (Blueprint $table) {
            // Drop foreign key dan column jenis_id
            $table->dropForeign(['jenis_id']);
            $table->dropColumn('jenis_id');

            // Hapus foto_persil column
            $table->dropColumn('foto_persil');
        });

        Schema::table('persil', function (Blueprint $table) {
            // Tambah penggunaan sebagai varchar
            $table->string('penggunaan')->nullable()->after('luas_m2');

            // Update rt, rw jadi varchar(3)
            $table->string('rt', 3)->nullable()->change();
            $table->string('rw', 3)->nullable()->change();
        });

        // 3. Update pemilik_warga_id foreign key ke warga table
        Schema::table('persil', function (Blueprint $table) {
            $table->dropForeign(['pemilik_warga_id']);
            $table->foreign('pemilik_warga_id')->references('warga_id')->on('warga')->onDelete('set null');
        });

        // 4. Update dokumen_persil - hapus file_dokumen (akan pakai media table)
        Schema::table('dokumen_persil', function (Blueprint $table) {
            $table->dropColumn('file_dokumen');
        });

        // 5. Update peta_persil - hapus file_peta, ubah geojson ke json type
        Schema::table('peta_persil', function (Blueprint $table) {
            $table->dropColumn('file_peta');
        });

        // 6. Update sengketa_persil - hapus bukti_sengketa, update status enum
        Schema::table('sengketa_persil', function (Blueprint $table) {
            $table->dropColumn('bukti_sengketa');
        });

        // Ubah enum status dari 'baru' ke 'pending'
        DB::statement("ALTER TABLE sengketa_persil MODIFY status ENUM('pending', 'proses', 'selesai') DEFAULT 'pending'");

        // 7. Update users table - hapus guest dari role enum
        DB::statement("ALTER TABLE users MODIFY role ENUM('super_admin', 'admin', 'user') DEFAULT 'user'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore users role enum
        DB::statement("ALTER TABLE users MODIFY role ENUM('super_admin', 'admin', 'user', 'guest') DEFAULT 'user'");

        // Restore sengketa_persil
        DB::statement("ALTER TABLE sengketa_persil MODIFY status ENUM('baru', 'proses', 'selesai') DEFAULT 'baru'");
        Schema::table('sengketa_persil', function (Blueprint $table) {
            $table->string('bukti_sengketa')->nullable();
        });

        // Restore peta_persil
        Schema::table('peta_persil', function (Blueprint $table) {
            $table->string('file_peta')->nullable();
        });

        // Restore dokumen_persil
        Schema::table('dokumen_persil', function (Blueprint $table) {
            $table->string('file_dokumen')->nullable();
        });

        // Restore persil
        Schema::table('persil', function (Blueprint $table) {
            $table->dropForeign(['pemilik_warga_id']);
            $table->foreign('pemilik_warga_id')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('persil', function (Blueprint $table) {
            $table->dropColumn('penggunaan');
            $table->unsignedBigInteger('jenis_id')->nullable();
            $table->foreign('jenis_id')->references('jenis_id')->on('jenis_penggunaan')->onDelete('set null');
            $table->string('foto_persil')->nullable();
        });

        // Drop media table
        Schema::dropIfExists('media');
    }
};
