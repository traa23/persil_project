<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== HAPUS USER BARU (ID > 99) ===\n\n";

$toDelete = DB::table('users')->where('id', '>', 99)->get();
echo "User yang akan dihapus:\n";
foreach ($toDelete as $u) {
    echo "  - [{$u->id}] {$u->email}\n";
}

$deleted = DB::table('users')->where('id', '>', 99)->delete();
echo "\nDeleted: {$deleted} users\n";

echo "\nTotal users sekarang: " . DB::table('users')->count() . "\n";
echo "=== SELESAI ===\n";
