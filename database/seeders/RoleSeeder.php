<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles_and_permissions = ["Admin", "Sales", "Doctor", "MedicineVital", "Bill", "Lab", "Dispatcher", "TPA", 'PostSales', "Vendor"];

        foreach ($roles_and_permissions as $role) {
            Role::create(['name' => $role]);
        }
    }
}
