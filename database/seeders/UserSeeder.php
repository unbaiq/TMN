<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🧑‍💼 Super Admin
        User::updateOrCreate(
            ['email' => 'superadmin@tmn.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('superadmin123'),
                'role' => 'admin', // You can extend to 'superadmin' if you add it to enum
            ]
        );

        // 👨‍💼 Admin
        User::updateOrCreate(
            ['email' => 'admin@tmn.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // 👤 Member
        User::updateOrCreate(
            ['email' => 'member@tmn.com'],
            [
                'name' => 'Default Member',
                'password' => Hash::make('member123'),
                'role' => 'member',
            ]
        );
    }
}
