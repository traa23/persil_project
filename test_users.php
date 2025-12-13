<?php

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';

$app->boot();

$users = \App\Models\User::all(['name', 'email', 'role']);

echo "=== Test Users ===\n";
foreach ($users as $user) {
    echo sprintf("%s (%s) - Role: %s\n", $user->name, $user->email, $user->role);
}
echo "\n";
