<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Student',
            'email' => 'student@example.com',
            'role' => 0,
            'active' => true,
            'password' => bcrypt('password'),
        ]);
        User::create([
            'name' => 'Teacher',
            'email' => 'teacher@example.com',
            'role' => 1,
            'active' => true,
            'password' => bcrypt('password'),
        ]);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => 3,
            'active' => true,
            'password' => bcrypt('password'),
        ]);

        // add a second admin on a old email
        User::create([
            'name' => 'Admin 2',
            'email' => 'admin@admin.com',
            'role' => 3,
            'active' => true,
            'password' => bcrypt('password'),
        ]);
    }
}
