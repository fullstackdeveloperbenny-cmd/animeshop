<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@animeshop.test',
            'password' => Hash::make('password'),
            'role' => UserRole::ADMIN,
        ]);

        User::create([
            'name' => 'Test Klant',
            'email' => 'klant@animeshop.test',
            'password' => Hash::make('password'),
            'role' => UserRole::KLANT,
        ]);
    }
}
