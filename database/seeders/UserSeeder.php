<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 🔑 Admin user
        User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role'     => 'Admin',       // <-- Added role
        ]);

        // 👨‍✈️ Staff users
        User::create([
            'name'     => 'John Doe',
            'email'    => 'johndoe@example.com',
            'password' => Hash::make('password123'),
            'role'     => 'Staff',       // <-- Added role
        ]);

        User::create([
            'name'     => 'Jane Smith',
            'email'    => 'janesmith@example.com',
            'password' => Hash::make('password123'),
            'role'     => 'Staff',       // <-- Added role
        ]);

        // 👥 Random regular users
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name'     => 'User '.$i,
                'email'    => 'user'.$i.'@example.com',
                'password' => Hash::make('password123'),
                'role'     => 'passenger',     // <-- Added role
            ]);
        }
    }
}
