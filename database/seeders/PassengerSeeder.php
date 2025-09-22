<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Passenger;
use App\Models\Flight;
use Illuminate\Support\Str;

class PassengerSeeder extends Seeder
{
    public function run(): void
    {
        $flights = Flight::all();

        if ($flights->isEmpty()) {
            $this->command->info('No flights found, please run FlightSeeder first.');
            return;
        }

        $firstNames = ['John', 'Jane', 'Michael', 'Emily', 'David', 'Sarah', 'Daniel', 'Olivia', 'Peter', 'Grace'];
        $lastNames = ['Smith', 'Doe', 'Johnson', 'Williams', 'Brown', 'Jones', 'Davis', 'Miller', 'Wilson', 'Taylor'];
        $specialRequests = [
            'Vegetarian Meal', 'Wheelchair Assistance', 'Extra Legroom', 
            'Window Seat', 'Aisle Seat', 'Infant on Board', 'Special Assistance'
        ];

        foreach ($flights as $flight) {
            for ($i = 0; $i < rand(5, 15); $i++) { // 5-15 passengers per flight
                $name = $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
                Passenger::create([
                    'flight_id' => $flight->id,
                    'name' => $name,
                    'email' => strtolower(Str::random(5)) . '@example.com',
                    'phone' => '+2507' . rand(10000000, 99999999),
                    'passport_number' => strtoupper(Str::random(2)) . rand(100000, 999999),
                    'special_requests' => $specialRequests[array_rand($specialRequests)],
                ]);
            }
        }
    }
}
