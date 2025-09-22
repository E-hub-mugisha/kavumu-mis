<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Flight;
use App\Models\Airline;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FlightSeeder extends Seeder
{
    public function run(): void
    {
        $airlines = Airline::all();

        if ($airlines->isEmpty()) {
            $this->command->info('No airlines found, please run AirlineSeeder first.');
            return;
        }

        $destinations = ['Kigali', 'Nairobi', 'Addis Ababa', 'Dar es Salaam', 'Entebbe', 'Juba', 'Dubai', 'Doha'];

        foreach ($airlines as $airline) {
            for ($i = 1; $i <= 5; $i++) { // 5 flights per airline
                $origin = $destinations[array_rand($destinations)];
                do {
                    $destination = $destinations[array_rand($destinations)];
                } while ($destination === $origin);

                $departure = Carbon::now()->addDays(rand(1, 30))->addHours(rand(0, 23))->addMinutes(rand(0, 59));
                $arrival = (clone $departure)->addHours(rand(1, 5)); // flight duration 1-5 hours

                Flight::create([
                    'airline_id' => $airline->id,
                    'flight_number' => strtoupper(Str::random(2)) . rand(100, 999),
                    'origin' => $origin,
                    'destination' => $destination,
                    'departure_time' => $departure,
                    'arrival_time' => $arrival,
                    'available_seats' => rand(50, 200),
                    'status' => 'Scheduled',
                ]);
            }
        }
    }
}
