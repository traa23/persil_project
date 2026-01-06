<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FotoPersilSeeder extends Seeder
{
    public function run(): void
    {
        $persilIds = DB::table('persil')->pluck('persil_id')->toArray();

        $data = [];

        $fileNames = [
            'foto-bidang-depan.jpg', 'foto-bidang-belakang.jpg', 'foto-sudut-timur.jpg',
            'foto-sudut-barat.jpg', 'foto-sudut-utara.jpg', 'foto-sudut-selatan.jpg',
            'foto-akses-jalan.jpg', 'foto-pagar.jpg', 'foto-kondisi-tanah.jpg',
            'foto-luas-bidang.jpg', 'foto-batas-properti.jpg', 'foto-dokumentasi-keseluruhan.jpg',
        ];

        // Buat 2-4 foto untuk setiap persil
        foreach ($persilIds as $persilId) {
            $jumlahFoto = mt_rand(2, 4);
            for ($i = 0; $i < $jumlahFoto; $i++) {
                $data[] = [
                    'persil_id'     => $persilId,
                    'file_path'     => 'persil/' . $persilId . '/' . $fileNames[array_rand($fileNames)],
                    'original_name' => 'foto_persil_' . $persilId . '_' . ($i + 1) . '.jpg',
                    'file_size'     => mt_rand(1000000, 5000000), // 1MB - 5MB
                    'created_at'    => now()->subDays(mt_rand(1, 365)),
                    'updated_at'    => now(),
                ];
            }
        }

        DB::table('foto_persil')->insert($data);
    }
}
