<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the main admin user
        User::create([
            'f_name' => 'Main',
            'l_name' => 'Admin',
            'role_id' => 1, // Assuming 'Admin' role has an ID of 1
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Use a strong password in production
        ]);

        // Create additional users for all roles
        User::create([
            'f_name' => 'Sales',
            'l_name' => 'User',
            'role_id' => 2, // Assuming 'Sales' role has an ID of 2
            'email' => 'sales@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'f_name' => 'Doctor',
            'l_name' => 'User',
            'role_id' => 3, // Assuming 'Doctor' role has an ID of 3
            'email' => 'doctor@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'f_name' => 'Medicine',
            'l_name' => 'Vital User',
            'role_id' => 4, // Assuming 'MedicineVital' role has an ID of 4
            'email' => 'medicine@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'f_name' => 'Billing',
            'l_name' => 'User',
            'role_id' => 5, // Assuming 'Bill' role has an ID of 5
            'email' => 'billing@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'f_name' => 'Lab',
            'l_name' => 'User',
            'role_id' => 6, // Assuming 'Lab' role has an ID of 6
            'email' => 'lab@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'f_name' => 'Dispatcher',
            'l_name' => 'User',
            'role_id' => 7, // Assuming 'Dispatcher' role has an ID of 7
            'email' => 'dispatcher@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'f_name' => 'DispatcherTPA',
            'l_name' => 'User',
            'role_id' => 8, // Assuming 'DispatcherTPA' role has an ID of 8
            'email' => 'dispatchertpa@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'f_name' => 'Post',
            'l_name' => 'Sales',
            'role_id' => 9, // Assuming 'PostSales' role has an ID of 9
            'email' => 'postsales@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'f_name' => 'Vendor',
            'l_name' => 'User',
            'role_id' => 9, // Assuming 'Vendor' role has an ID of 9
            'email' => 'vendor@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
