<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * MediaSeeder - Seeder untuk tabel media
 * Tabel media menyimpan file secara universal untuk berbagai tabel (persil, dokumen, peta, sengketa)
 */
class MediaSeeder extends Seeder
{
    public function run(): void
    {
        $persilIds   = DB::table('persil')->pluck('persil_id')->toArray();
        $dokumenIds  = DB::table('dokumen_persil')->pluck('dokumen_id')->toArray();
        $petaIds     = DB::table('peta_persil')->pluck('peta_id')->toArray();
        $sengketaIds = DB::table('sengketa_persil')->pluck('sengketa_id')->toArray();

        $data = [];

        // Sample media untuk persil (foto persil) - semua persil
        foreach ($persilIds as $persilId) {
            $data[] = [
                'ref_table'  => 'persil',
                'ref_id'     => $persilId,
                'file_url'   => 'uploads/persil/foto_' . $persilId . '.jpg',
                'caption'    => 'Foto lahan persil ' . $persilId,
                'mime_type'  => 'image/jpeg',
                'sort_order' => 0,
                'created_at' => now()->subDays(mt_rand(1, 100)),
                'updated_at' => now(),
            ];
        }

        // Sample media untuk dokumen_persil
        foreach (array_slice($dokumenIds, 0, 30) as $dokumenId) {
            $data[] = [
                'ref_table'  => 'dokumen_persil',
                'ref_id'     => $dokumenId,
                'file_url'   => 'uploads/dokumen/dok_' . $dokumenId . '.pdf',
                'caption'    => 'Scan dokumen ' . $dokumenId,
                'mime_type'  => 'application/pdf',
                'sort_order' => 0,
                'created_at' => now()->subDays(mt_rand(1, 100)),
                'updated_at' => now(),
            ];
        }

        // Sample media untuk peta_persil - semua peta
        foreach (array_slice($petaIds, 0, 21) as $petaId) {
            $data[] = [
                'ref_table'  => 'peta_persil',
                'ref_id'     => $petaId,
                'file_url'   => 'uploads/peta/peta_' . $petaId . '.png',
                'caption'    => 'Peta visual persil ' . $petaId,
                'mime_type'  => 'image/png',
                'sort_order' => 0,
                'created_at' => now()->subDays(mt_rand(1, 100)),
                'updated_at' => now(),
            ];
        }

        // Sample media untuk sengketa_persil (bukti sengketa) - 30 records
        foreach (array_slice($sengketaIds, 0, 30) as $sengketaId) {
            $data[] = [
                'ref_table'  => 'sengketa_persil',
                'ref_id'     => $sengketaId,
                'file_url'   => 'uploads/sengketa/bukti_' . $sengketaId . '.pdf',
                'caption'    => 'Bukti sengketa ' . $sengketaId,
                'mime_type'  => 'application/pdf',
                'sort_order' => 0,
                'created_at' => now()->subDays(mt_rand(1, 100)),
                'updated_at' => now(),
            ];
        }

        DB::table('media')->insert($data);
    }
}
