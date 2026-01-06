<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== TEST EMAIL MATCHING ===\n\n";

// 1. Lihat semua users
echo "1. DAFTAR USERS:\n";
$users = DB::table('users')->select('id', 'name', 'email', 'role')->get();
foreach ($users as $u) {
    echo "   - [{$u->id}] {$u->name} ({$u->email}) - Role: {$u->role}\n";
}

echo "\n2. DAFTAR WARGA (dengan email):\n";
$wargas = DB::table('warga')->whereNotNull('email')->where('email', '!=', '')->select('warga_id', 'nama', 'email')->get();
foreach ($wargas->take(10) as $w) {
    echo "   - [{$w->warga_id}] {$w->nama} ({$w->email})\n";
}
echo "   ... Total warga dengan email: " . $wargas->count() . "\n";

echo "\n3. USERS YANG EMAIL-NYA COCOK DENGAN WARGA:\n";
$matches = DB::table('users')
    ->join('warga', 'users.email', '=', 'warga.email')
    ->select('users.id', 'users.email', 'users.name', 'users.role', 'warga.nama as warga_nama', 'warga.warga_id')
    ->get();

if ($matches->count() == 0) {
    echo "   TIDAK ADA USER YANG EMAIL-NYA COCOK DENGAN WARGA!\n";
    echo "\n   => Untuk testing, Anda perlu:\n";
    echo "   => 1. Update email warga agar sama dengan salah satu user, ATAU\n";
    echo "   => 2. Buat user baru dengan email yang sama dengan warga\n";
} else {
    foreach ($matches as $m) {
        echo "   - User: {$m->name} ({$m->email})\n";
        echo "     Matched Warga: {$m->warga_nama} (ID: {$m->warga_id})\n";

        // Cek persil yang dimiliki
        $persilCount = DB::table('persil')->where('pemilik_warga_id', $m->warga_id)->count();
        echo "     Jumlah Persil: {$persilCount}\n\n";
    }
}

echo "\n4. REKOMENDASI UNTUK TESTING:\n";
$wargaWithPersil = DB::table('warga')
    ->join('persil', 'warga.warga_id', '=', 'persil.pemilik_warga_id')
    ->select('warga.warga_id', 'warga.nama', 'warga.email', DB::raw('COUNT(*) as persil_count'))
    ->groupBy('warga.warga_id', 'warga.nama', 'warga.email')
    ->orderBy('persil_count', 'desc')
    ->take(5)
    ->get();

echo "   Warga yang memiliki persil (untuk dijadikan test user):\n";
foreach ($wargaWithPersil as $w) {
    echo "   - [{$w->warga_id}] {$w->nama}\n";
    echo "     Email: " . ($w->email ?: 'KOSONG') . "\n";
    echo "     Jumlah Persil: {$w->persil_count}\n\n";
}

echo "\n=== SELESAI ===\n";
