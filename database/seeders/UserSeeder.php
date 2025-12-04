<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
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
            'email' => 'admin123@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Staff User',
            'email' => 'staff123@gmail.com',
            'password' => Hash::make('staff123'),
            'role' => 'staff',
        ]);

        User::create([
            'name' => 'Customer User',
            'email' => 'customer123@gmail.com',
            'password' => Hash::make('customer123'),
            'role' => 'customer',
        ]);
    }
}
