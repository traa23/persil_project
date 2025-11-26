<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Persil;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create sample users for Pemilik dropdown
        $users = [
            ['name' => 'Putra', 'email' => 'putra@example.com', 'password' => bcrypt('password')],
            ['name' => 'fajar', 'email' => 'fajar@example.com', 'password' => bcrypt('password')],
            ['name' => 'Anugrah', 'email' => 'anugrah@example.com', 'password' => bcrypt('password')],
            ['name' => 'traa', 'email' => 'traa@example.com', 'password' => bcrypt('password')],
            ['name' => 'toyy', 'email' => 'toyy@example.com', 'password' => bcrypt('password')],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        // Create sample persil data for pagination testing
        $penggunaanOptions = ['Perumahan', 'Pertanian', 'Perkebunan', 'Perdagangan', 'Industri', 'Kosong'];
        $rtOptions = ['001', '002', '003', '004', '005'];
        $rwOptions = ['01', '02', '03', '04', '05'];
        $lokasiOptions = [
            'Jl. Merdeka No. ',
            'Jl. Sudirman No. ',
            'Jl. Ahmad Yani No. ',
            'Jl. Gatot Subroto No. ',
            'Jl. Diponegoro No. ',
        ];

        $userIds = User::pluck('id')->toArray();

        // Generate 25 sample persil data to test pagination (paginate is 12 per page)
        for ($i = 1; $i <= 25; $i++) {
            Persil::firstOrCreate(
                ['kode_persil' => 'PSL-' . str_pad($i, 4, '0', STR_PAD_LEFT)],
                [
                    'pemilik_warga_id' => $userIds[array_rand($userIds)],
                    'luas_m2' => rand(50, 500),
                    'penggunaan' => $penggunaanOptions[array_rand($penggunaanOptions)],
                    'alamat_lahan' => $lokasiOptions[array_rand($lokasiOptions)] . rand(1, 100),
                    'rt' => $rtOptions[array_rand($rtOptions)],
                    'rw' => $rwOptions[array_rand($rwOptions)],
                ]
            );
        }
    }
}
