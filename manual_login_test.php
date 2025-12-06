<?php
// manual_login_test.php
require 'vendor/autoload.php';
$app    = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

$credentials = [
    'email'    => 'admin@persil.test',
    'password' => 'password',
];

echo "Testing login with: " . $credentials['email'] . "\n";
echo "Password: " . $credentials['password'] . "\n\n";

// Check if user exists
$user = \App\Models\User::where('email', $credentials['email'])->first();
if (! $user) {
    echo "ERROR: User not found!\n";
    exit;
}

echo "User found:\n";
echo "  ID: " . $user->id . "\n";
echo "  Name: " . $user->name . "\n";
echo "  Email: " . $user->email . "\n";
echo "  Role: " . $user->role . "\n";
echo "  Password Hash: " . substr($user->password, 0, 20) . "...\n\n";

// Try password verification
$passwordCorrect = Hash::check($credentials['password'], $user->password);
echo "Password verification: " . ($passwordCorrect ? "PASS" : "FAIL") . "\n";

// Try Auth::attempt()
$result = Auth::attempt($credentials);
echo "Auth::attempt() result: " . ($result ? "PASS" : "FAIL") . "\n";

if ($result) {
    echo "\nAuth successful! User ID: " . Auth::id() . "\n";
    echo "Auth user role: " . Auth::user()->role . "\n";
}
