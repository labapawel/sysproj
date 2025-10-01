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
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'role' => 3, // ustawienie roli na admin
            'active' => true,
            'password' => bcrypt('password'),
        ]);
    }
}
