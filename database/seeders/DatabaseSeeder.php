<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            WargaSeeder::class,
            JenisPenggunaanSeeder::class,
            PersilSeeder::class,
            DokumenPersilSeeder::class,
            PetaPersilSeeder::class,
            FotoPersilSeeder::class,
            SengketaPersilSeeder::class,
            MediaSeeder::class, // Tabel media sekarang sudah ada
        ]);
    }
}

/*
// OLD CODE (before refactoring):
// use App\Models\JenisPenggunaan;
// use App\Models\Persil;
// use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
//
// class DatabaseSeeder extends Seeder
// {
//     use WithoutModelEvents;
//
//     public function run(): void
//     {
//         // Call UserSeeder first to create users
//         $this->call(UserSeeder::class);
//
//         // Call WargaSeeder to create warga data
//         $this->call(WargaSeeder::class);
//
//         // $admin = User::create([
//         //     'name'     => 'Admin Persil',
//         //     'email'    => 'admin@persil.local',
//         //     'password' => bcrypt('password'),
//         //     'role'     => 'admin',
//         // ]);
//         //
//         // $guest1 = User::create([
//         //     'name'     => 'Warga Satu',
//         //     'email'    => 'guest1@persil.local',
//         //     'password' => bcrypt('password'),
//         //     'role'     => 'guest',
//         //     'admin_id' => $admin->id,
//         // ]);
//         //
//         // $guest2 = User::create([
//         //     'name'     => 'Warga Dua',
//         //     'email'    => 'guest2@persil.local',
//         //     'password' => bcrypt('password'),
//         //     'role'     => 'guest',
//         //     'admin_id' => $admin->id,
//         // ]);
//
//         // Get admin user from seeder for persil data
//         $admin = User::where('email', 'admin@persil.com')->first();
//         if (! $admin) {
//             $admin = User::where('role', 'admin')->first();
//         }
//
//         // Get guest users for persil data
//         $guests = User::where('role', 'guest')->get();
//         if ($guests->isEmpty()) {
//             // Create Guest Users if none exist
//             $guest1 = User::create([
//                 'name'     => 'Warga Satu',
//                 'email'    => 'guest1@persil.local',
//                 'password' => bcrypt('password'),
//                 'role'     => 'guest',
//                 'admin_id' => $admin->id,
//             ]);
//
//             $guest2 = User::create([
//                 'name'     => 'Warga Dua',
//                 'email'    => 'guest2@persil.local',
//                 'password' => bcrypt('password'),
//                 'role'     => 'guest',
//                 'admin_id' => $admin->id,
//             ]);
//             $guests = [$guest1, $guest2];
//         }
//
//         // Create Jenis Penggunaan
//         $jenisData = [
//             ['nama_penggunaan' => 'Tanah Pertanian', 'keterangan' => 'Lahan untuk kegiatan pertanian'],
//             ['nama_penggunaan' => 'Pemukiman', 'keterangan' => 'Lahan untuk pemukiman/perumahan'],
//             ['nama_penggunaan' => 'Perdagangan', 'keterangan' => 'Lahan untuk kegiatan perdagangan'],
//             ['nama_penggunaan' => 'Pabrik/Industri', 'keterangan' => 'Lahan untuk industri dan manufaktur'],
//             ['nama_penggunaan' => 'Ruang Terbuka', 'keterangan' => 'Ruang terbuka hijau/publik'],
//         ];
//
//         foreach ($jenisData as $jenis) {
//             JenisPenggunaan::create($jenis);
//         }
//
//         // Create Sample Persil Data
//         if (count($guests) >= 1) {
//             Persil::create([
//                 'kode_persil'      => 'PERSIL-001',
//                 'pemilik_warga_id' => $guests[0]->id,
//                 'luas_m2'          => 500.50,
//                 'jenis_id'         => 1,
//                 'alamat_lahan'     => 'Jl. Raya Desa, Kecamatan Maju, Kabupaten Sukses',
//                 'rt'               => 1,
//                 'rw'               => 2,
//             ]);
//         }
//
//         if (count($guests) >= 2) {
//             Persil::create([
//                 'kode_persil'      => 'PERSIL-002',
//                 'pemilik_warga_id' => $guests[1]->id,
//                 'luas_m2'          => 800.75,
//                 'jenis_id'         => 2,
//                 'alamat_lahan'     => 'Jl. Makmur No. 10, Kelurahan Sejahtera',
//                 'rt'               => 3,
//                 'rw'               => 4,
//             ]);
//         }
//     }
// }
*/
