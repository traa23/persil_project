<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserWargaLinkSeeder extends Seeder
{
    /**
     * Seeder untuk membuat user dengan email yang sama dengan warga
     * agar bisa test fitur user portal
     *
     * Hanya membuat user BARU, TIDAK mengubah data warga di database
     */
    public function run(): void
    {
        // Ambil warga yang memiliki persil (untuk testing yang meaningful)
        $wargasWithPersil = DB::table('warga')
            ->join('persil', 'warga.warga_id', '=', 'persil.pemilik_warga_id')
            ->whereNotNull('warga.email')
            ->where('warga.email', '!=', '')
            ->select('warga.warga_id', 'warga.nama', 'warga.email', DB::raw('COUNT(*) as persil_count'))
            ->groupBy('warga.warga_id', 'warga.nama', 'warga.email')
            ->orderBy('persil_count', 'desc')
            ->take(10) // Ambil 10 warga yang punya persil terbanyak
            ->get();

        $created = 0;
        $skipped = 0;

        foreach ($wargasWithPersil as $warga) {
            // Cek apakah user dengan email ini sudah ada
            $exists = User::where('email', $warga->email)->exists();

            if (! $exists) {
                User::create([
                    'name'     => $warga->nama,
                    'email'    => $warga->email,
                    'password' => Hash::make('password123'), // Password default untuk testing
                    'role'     => 'user',
                ]);

                $this->command->info("Created user: {$warga->nama} ({$warga->email}) - {$warga->persil_count} persil");
                $created++;
            } else {
                $this->command->warn("Skipped (already exists): {$warga->email}");
                $skipped++;
            }
        }

        $this->command->newLine();
        $this->command->info("=================================");
        $this->command->info("Created: {$created} users");
        $this->command->info("Skipped: {$skipped} users");
        $this->command->info("=================================");
        $this->command->newLine();
        $this->command->info("Password untuk semua user: password123");
    }
}
