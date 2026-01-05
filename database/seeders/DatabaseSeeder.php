<?php
namespace Database\Seeders;

use App\Models\JenisPenggunaan;
use App\Models\Persil;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name'     => 'Admin Persil',
            'email'    => 'admin@persil.local',
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);

        // Create Guest Users
        $guest1 = User::create([
            'name'     => 'Warga Satu',
            'email'    => 'guest1@persil.local',
            'password' => bcrypt('password'),
            'role'     => 'guest',
            'admin_id' => $admin->id,
        ]);

        $guest2 = User::create([
            'name'     => 'Warga Dua',
            'email'    => 'guest2@persil.local',
            'password' => bcrypt('password'),
            'role'     => 'guest',
            'admin_id' => $admin->id,
        ]);

        // Create Jenis Penggunaan
        $jenisData = [
            ['nama_penggunaan' => 'Tanah Pertanian', 'keterangan' => 'Lahan untuk kegiatan pertanian'],
            ['nama_penggunaan' => 'Pemukiman', 'keterangan' => 'Lahan untuk pemukiman/perumahan'],
            ['nama_penggunaan' => 'Perdagangan', 'keterangan' => 'Lahan untuk kegiatan perdagangan'],
            ['nama_penggunaan' => 'Pabrik/Industri', 'keterangan' => 'Lahan untuk industri dan manufaktur'],
            ['nama_penggunaan' => 'Ruang Terbuka', 'keterangan' => 'Ruang terbuka hijau/publik'],
        ];

        foreach ($jenisData as $jenis) {
            JenisPenggunaan::create($jenis);
        }

        // Create Sample Persil Data
        Persil::create([
            'kode_persil'      => 'PERSIL-001',
            'pemilik_warga_id' => $guest1->id,
            'luas_m2'          => 500.50,
            'jenis_id'         => 1,
            'alamat_lahan'     => 'Jl. Raya Desa, Kecamatan Maju, Kabupaten Sukses',
            'rt'               => 1,
            'rw'               => 2,
        ]);

        Persil::create([
            'kode_persil'      => 'PERSIL-002',
            'pemilik_warga_id' => $guest2->id,
            'luas_m2'          => 800.75,
            'jenis_id'         => 2,
            'alamat_lahan'     => 'Jl. Makmur No. 10, Kelurahan Sejahtera',
            'rt'               => 3,
            'rw'               => 4,
        ]);
    }
}
