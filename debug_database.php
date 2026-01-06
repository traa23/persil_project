<?php
/**
 * Database Debug Script
 * Jalankan dengan: php debug_database.php
 */

require __DIR__ . '/vendor/autoload.php';

$app    = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "\n";
echo "╔══════════════════════════════════════════════════════════════════╗\n";
echo "║           DATABASE DEBUG - PERSIL ADMIN PROJECT                  ║\n";
echo "║           " . date('Y-m-d H:i:s') . "                               ║\n";
echo "╚══════════════════════════════════════════════════════════════════╝\n\n";

// Database Connection Info
echo "═══════════════════════════════════════════════════════════════════\n";
echo "📡 DATABASE CONNECTION\n";
echo "═══════════════════════════════════════════════════════════════════\n";
$connection = config('database.default');
$dbConfig   = config("database.connections.{$connection}");
echo "Driver     : {$dbConfig['driver']}\n";
echo "Host       : {$dbConfig['host']}\n";
echo "Database   : {$dbConfig['database']}\n";
echo "Username   : {$dbConfig['username']}\n";
echo "\n";

// Table Summary
echo "═══════════════════════════════════════════════════════════════════\n";
echo "📊 TABLE SUMMARY\n";
echo "═══════════════════════════════════════════════════════════════════\n";

$tables = [
    'users'            => 'Users (Admin/User)',
    'warga'            => 'Warga (Pemilik Persil)',
    'persil'           => 'Data Persil',
    'dokumen_persil'   => 'Dokumen Persil',
    'peta_persil'      => 'Peta Persil',
    'sengketa_persil'  => 'Sengketa Persil',
    'media'            => 'Media Files',
    'jenis_penggunaan' => 'Jenis Penggunaan',
];

$totalRecords = 0;
echo str_pad("Table", 25) . str_pad("Records", 10) . "Status\n";
echo "─────────────────────────────────────────────────────────────────\n";

foreach ($tables as $table => $description) {
    if (Schema::hasTable($table)) {
        $count = DB::table($table)->count();
        $totalRecords += $count;
        $status = $count > 0 ? "✅ OK" : "⚠️ Empty";
        echo str_pad($table, 25) . str_pad($count, 10) . $status . "\n";
    } else {
        echo str_pad($table, 25) . str_pad("-", 10) . "❌ Not Found\n";
    }
}
echo "─────────────────────────────────────────────────────────────────\n";
echo str_pad("TOTAL", 25) . str_pad($totalRecords, 10) . "\n\n";

// Users by Role
echo "═══════════════════════════════════════════════════════════════════\n";
echo "👤 USERS BY ROLE\n";
echo "═══════════════════════════════════════════════════════════════════\n";
$usersByRole = DB::table('users')
    ->select('role', DB::raw('count(*) as total'))
    ->groupBy('role')
    ->get();

foreach ($usersByRole as $role) {
    $icon = match ($role->role) {
        'super_admin' => '👑',
        'admin'       => '🔧',
        'user'        => '👤',
        default       => '❓'
    };
    echo "{$icon} {$role->role}: {$role->total}\n";
}
echo "\n";

// Sample Users (Super Admin & Admin)
echo "═══════════════════════════════════════════════════════════════════\n";
echo "🔐 SAMPLE LOGIN CREDENTIALS\n";
echo "═══════════════════════════════════════════════════════════════════\n";

$superAdmin = DB::table('users')->where('role', 'super_admin')->first();
if ($superAdmin) {
    echo "Super Admin:\n";
    echo "  Email    : {$superAdmin->email}\n";
    echo "  Password : password (default)\n\n";
}

$admin = DB::table('users')->where('role', 'admin')->first();
if ($admin) {
    echo "Admin:\n";
    echo "  Email    : {$admin->email}\n";
    echo "  Password : password (default)\n\n";
}

$user = DB::table('users')->where('role', 'user')->first();
if ($user) {
    echo "User:\n";
    echo "  Email    : {$user->email}\n";
    echo "  Password : password (default)\n\n";
}

// Persil Statistics
echo "═══════════════════════════════════════════════════════════════════\n";
echo "🏠 PERSIL STATISTICS\n";
echo "═══════════════════════════════════════════════════════════════════\n";

$persilByPenggunaan = DB::table('persil')
    ->select('penggunaan', DB::raw('count(*) as total'), DB::raw('SUM(luas_m2) as total_luas'))
    ->groupBy('penggunaan')
    ->get();

echo str_pad("Penggunaan", 20) . str_pad("Jumlah", 10) . "Total Luas (m²)\n";
echo "─────────────────────────────────────────────────────────────────\n";
foreach ($persilByPenggunaan as $p) {
    echo str_pad($p->penggunaan, 20) . str_pad($p->total, 10) . number_format($p->total_luas, 2) . "\n";
}
echo "\n";

// Sengketa Statistics
echo "═══════════════════════════════════════════════════════════════════\n";
echo "⚖️ SENGKETA STATISTICS\n";
echo "═══════════════════════════════════════════════════════════════════\n";

$sengketaByStatus = DB::table('sengketa_persil')
    ->select('status', DB::raw('count(*) as total'))
    ->groupBy('status')
    ->get();

foreach ($sengketaByStatus as $s) {
    $icon = match ($s->status) {
        'pending' => '🕐',
        'proses'  => '🔄',
        'selesai' => '✅',
        default   => '❓'
    };
    echo "{$icon} {$s->status}: {$s->total}\n";
}
echo "\n";

// Media Statistics
echo "═══════════════════════════════════════════════════════════════════\n";
echo "📁 MEDIA STATISTICS\n";
echo "═══════════════════════════════════════════════════════════════════\n";

$mediaByRef = DB::table('media')
    ->select('ref_table', DB::raw('count(*) as total'))
    ->groupBy('ref_table')
    ->get();

foreach ($mediaByRef as $m) {
    echo "📄 {$m->ref_table}: {$m->total} files\n";
}
echo "\n";

// Warga Statistics
echo "═══════════════════════════════════════════════════════════════════\n";
echo "👥 WARGA STATISTICS\n";
echo "═══════════════════════════════════════════════════════════════════\n";

$wargaByGender = DB::table('warga')
    ->select('jenis_kelamin', DB::raw('count(*) as total'))
    ->groupBy('jenis_kelamin')
    ->get();

foreach ($wargaByGender as $w) {
    $icon  = $w->jenis_kelamin === 'L' ? '👨' : '👩';
    $label = $w->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    echo "{$icon} {$label}: {$w->total}\n";
}

$wargaByAgama = DB::table('warga')
    ->select('agama', DB::raw('count(*) as total'))
    ->groupBy('agama')
    ->orderByDesc('total')
    ->get();

echo "\nBy Agama:\n";
foreach ($wargaByAgama as $w) {
    echo "  - {$w->agama}: {$w->total}\n";
}
echo "\n";

// Sample Data Preview
echo "═══════════════════════════════════════════════════════════════════\n";
echo "📋 SAMPLE DATA PREVIEW\n";
echo "═══════════════════════════════════════════════════════════════════\n";

// Sample Persil
echo "\n🏠 Sample Persil (5 records):\n";
echo "─────────────────────────────────────────────────────────────────\n";
$samplePersil = DB::table('persil')
    ->join('warga', 'persil.pemilik_warga_id', '=', 'warga.warga_id')
    ->select('persil.kode_persil', 'warga.nama as pemilik', 'persil.penggunaan', 'persil.luas_m2', 'persil.alamat_lahan')
    ->limit(5)
    ->get();

foreach ($samplePersil as $p) {
    echo "  [{$p->kode_persil}] {$p->pemilik} - {$p->penggunaan} ({$p->luas_m2} m²)\n";
    echo "    📍 {$p->alamat_lahan}\n";
}

// Sample Warga
echo "\n👥 Sample Warga (5 records):\n";
echo "─────────────────────────────────────────────────────────────────\n";
$sampleWarga = DB::table('warga')->limit(5)->get();
foreach ($sampleWarga as $w) {
    $gender = $w->jenis_kelamin === 'L' ? '👨' : '👩';
    echo "  {$gender} [{$w->no_ktp}] {$w->nama}\n";
    echo "    📧 {$w->email} | 📞 {$w->telp}\n";
}

// Sample Sengketa
echo "\n⚖️ Sample Sengketa (3 records):\n";
echo "─────────────────────────────────────────────────────────────────\n";
$sampleSengketa = DB::table('sengketa_persil')
    ->join('persil', 'sengketa_persil.persil_id', '=', 'persil.persil_id')
    ->select('persil.kode_persil', 'sengketa_persil.pihak_1', 'sengketa_persil.pihak_2', 'sengketa_persil.status')
    ->limit(3)
    ->get();

foreach ($sampleSengketa as $s) {
    $icon = match ($s->status) {
        'pending' => '🕐',
        'proses'  => '🔄',
        'selesai' => '✅',
        default   => '❓'
    };
    echo "  {$icon} [{$s->kode_persil}] {$s->pihak_1} vs {$s->pihak_2}\n";
}

// Foreign Key Integrity Check
echo "\n═══════════════════════════════════════════════════════════════════\n";
echo "🔗 FOREIGN KEY INTEGRITY CHECK\n";
echo "═══════════════════════════════════════════════════════════════════\n";

// Check persil.pemilik_warga_id references warga.warga_id
$orphanPersil = DB::table('persil')
    ->leftJoin('warga', 'persil.pemilik_warga_id', '=', 'warga.warga_id')
    ->whereNull('warga.warga_id')
    ->count();
echo($orphanPersil == 0 ? "✅" : "❌") . " persil.pemilik_warga_id -> warga.warga_id: " . ($orphanPersil == 0 ? "OK" : "{$orphanPersil} orphan records") . "\n";

// Check dokumen_persil.persil_id references persil.persil_id
$orphanDokumen = DB::table('dokumen_persil')
    ->leftJoin('persil', 'dokumen_persil.persil_id', '=', 'persil.persil_id')
    ->whereNull('persil.persil_id')
    ->count();
echo($orphanDokumen == 0 ? "✅" : "❌") . " dokumen_persil.persil_id -> persil.persil_id: " . ($orphanDokumen == 0 ? "OK" : "{$orphanDokumen} orphan records") . "\n";

// Check peta_persil.persil_id references persil.persil_id
$orphanPeta = DB::table('peta_persil')
    ->leftJoin('persil', 'peta_persil.persil_id', '=', 'persil.persil_id')
    ->whereNull('persil.persil_id')
    ->count();
echo($orphanPeta == 0 ? "✅" : "❌") . " peta_persil.persil_id -> persil.persil_id: " . ($orphanPeta == 0 ? "OK" : "{$orphanPeta} orphan records") . "\n";

// Check sengketa_persil.persil_id references persil.persil_id
$orphanSengketa = DB::table('sengketa_persil')
    ->leftJoin('persil', 'sengketa_persil.persil_id', '=', 'persil.persil_id')
    ->whereNull('persil.persil_id')
    ->count();
echo($orphanSengketa == 0 ? "✅" : "❌") . " sengketa_persil.persil_id -> persil.persil_id: " . ($orphanSengketa == 0 ? "OK" : "{$orphanSengketa} orphan records") . "\n";

echo "\n═══════════════════════════════════════════════════════════════════\n";
echo "✅ DEBUG COMPLETE\n";
echo "═══════════════════════════════════════════════════════════════════\n\n";
