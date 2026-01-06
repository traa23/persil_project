<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== TEST PASSWORD SEMUA USER ===\n\n";

$users = DB::table('users')->select('id', 'email', 'password')->get();

$pass     = 0;
$fail     = 0;
$failList = [];

foreach ($users as $user) {
    if (password_verify('password', $user->password)) {
        $pass++;
    } else {
        $fail++;
        $failList[] = $user->email;
    }
}

echo "HASIL:\n";
echo "- Password BENAR: {$pass} users\n";
echo "- Password SALAH: {$fail} users\n";

if ($fail > 0) {
    echo "\nUser yang password-nya BUKAN 'password':\n";
    foreach ($failList as $email) {
        echo "  - {$email}\n";
    }
}

echo "\n=== SELESAI ===\n";
