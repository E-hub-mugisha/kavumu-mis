<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role; // ✅ Import the model

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Staff']);
        Role::create(['name' => 'Passenger']);
    }
}
