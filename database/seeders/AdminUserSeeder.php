<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $staffRole = Role::firstOrCreate(['name' => 'staff']);

        // Create admin user
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin123@admin.gmail.com',
            'password' => Hash::make('admin123'),
        ]);
        $adminUser->assignRole($adminRole);

        // Create staff user
        $staffUser = User::create([
            'name' => 'Staff User',
            'email' => 'staff123@staff.gmail.com',
            'password' => Hash::make('staff123'),
        ]);
        $staffUser->assignRole($staffRole);
    }
}
