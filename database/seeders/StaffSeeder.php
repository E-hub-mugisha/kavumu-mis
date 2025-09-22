<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $positions = ['Security', 'Check-In', 'Pilot', 'Ground Crew', 'Admin'];
        $departments = ['Operations', 'Customer Service', 'Flight Control', 'Maintenance'];

        $users = User::all(); // existing users to link (optional)
        $userIndex = 0;

        for ($i = 1; $i <= 10; $i++) { // create 10 staff members
            $userId = null;

            // Optionally link staff to a user if available
            if ($users->count() > 0 && $userIndex < $users->count()) {
                $userId = $users[$userIndex]->id;
                $userIndex++;
            }

            Staff::create([
                'user_id' => $userId,
                'name' => 'Staff Member ' . $i,
                'email' => 'staff'.$i.'@example.com',
                'phone' => '+2507' . rand(10000000, 99999999),
                'position' => $positions[array_rand($positions)],
                'department' => $departments[array_rand($departments)],
                'hire_date' => Carbon::now()->subDays(rand(30, 365)),
                'status' => 'Active',
            ]);
        }
    }
}
