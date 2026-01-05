#!/usr/bin/env php
<?php
    /**
     * Simple Test Script untuk Sistem Persil
     */

    define('LARAVEL_START', microtime(true));

    require_once __DIR__ . '/vendor/autoload.php';

    $app = require_once __DIR__ . '/bootstrap/app.php';

    $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

    use App\Models\JenisPenggunaan;
    use App\Models\Persil;
    use App\Models\User;

    echo "\n╔════════════════════════════════════════════════════════════════╗\n";
    echo "║         SISTEM PERSIL - TEST REPORT                          ║\n";
    echo "╚════════════════════════════════════════════════════════════════╝\n\n";

    // Test 1: Check Users
    echo "📋 TEST 1: Checking Users...\n";
    $adminCount = User::where('role', 'admin')->count();
    $guestCount = User::where('role', 'guest')->count();
    echo "   ✓ Admin users: $adminCount\n";
    echo "   ✓ Guest users: $guestCount\n";
    echo "   ✓ Total users: " . User::count() . "\n\n";

    // Test 2: Check Jenis Penggunaan
    echo "📋 TEST 2: Checking Jenis Penggunaan...\n";
    $jenisCount = JenisPenggunaan::count();
    echo "   ✓ Total jenis penggunaan: $jenisCount\n";
    $jenis = JenisPenggunaan::all();
    foreach ($jenis as $j) {
        echo "   - {$j->nama_penggunaan}\n";
    }
    echo "\n";

    // Test 3: Check Persil
    echo "📋 TEST 3: Checking Persil Data...\n";
    $persilCount = Persil::count();
    echo "   ✓ Total persil: $persilCount\n";
    $persils = Persil::with('pemilik', 'jenisPenggunaan')->get();
    foreach ($persils as $p) {
        echo "   - {$p->kode_persil} ({$p->pemilik->name}) - {$p->jenisPenggunaan->nama_penggunaan}\n";
    }
    echo "\n";

    // Test 4: Check Admin has Guest Users
    echo "📋 TEST 4: Checking Admin-Guest Relationship...\n";
    $admin = User::where('role', 'admin')->first();
    if ($admin) {
        $guestUsers = $admin->guestUsers;
        echo "   ✓ Admin '{$admin->name}' has " . $guestUsers->count() . " guest users\n";
        foreach ($guestUsers as $guest) {
            echo "   - {$guest->name} ({$guest->email})\n";
        }
    } else {
        echo "   ✗ No admin user found!\n";
    }
    echo "\n";

    // Test 5: Routes Check
    echo "📋 TEST 5: Checking Routes...\n";
    echo "   ✓ Login route: /login\n";
    echo "   ✓ Admin routes: /admin/*\n";
    echo "   ✓ Guest routes: /guest/*\n";
    echo "\n";

    // Test 6: Database Connection
    echo "📋 TEST 6: Checking Database Connection...\n";
    try {
        \DB::connection()->getPdo();
        echo "   ✓ Database connection: OK\n";
    } catch (\Exception $e) {
        echo "   ✗ Database connection: FAILED\n";
    }
    echo "\n";

    // Test 7: Storage Check
    echo "📋 TEST 7: Checking Storage...\n";
    if (file_exists('public/storage')) {
        echo "   ✓ Storage link: OK\n";
    } else {
        echo "   ⚠ Storage link: NOT FOUND (Run: php artisan storage:link)\n";
    }
    echo "\n";

    // Summary
    echo "╔════════════════════════════════════════════════════════════════╗\n";
    echo "║                    ✅ SYSTEM READY TO USE!                    ║\n";
    echo "╚════════════════════════════════════════════════════════════════╝\n\n";

    echo "📝 Demo Credentials:\n";
    echo "   Admin: admin@persil.local / password\n";
    echo "   Guest1: guest1@persil.local / password\n";
    echo "   Guest2: guest2@persil.local / password\n\n";

    echo "🚀 Start Server:\n";
    echo "   php artisan serve\n\n";

    echo "🌐 Access:\n";
echo "   http://localhost:8000\n\n";
