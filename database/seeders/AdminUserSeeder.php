<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin Persil',
            'email' => 'admin@persil.test',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create some guest users
        User::create([
            'name' => 'Guest User 1',
            'email' => 'guest1@persil.test',
            'password' => bcrypt('password'),
            'role' => 'guest',
        ]);

        User::create([
            'name' => 'Guest User 2',
            'email' => 'guest2@persil.test',
            'password' => bcrypt('password'),
            'role' => 'guest',
        ]);
    }
}
