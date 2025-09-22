<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Baggage;
use App\Models\Passenger;
use Illuminate\Support\Str;

class BaggageSeeder extends Seeder
{
    public function run(): void
    {
        $passengers = Passenger::all();

        if ($passengers->isEmpty()) {
            $this->command->info('No passengers found, please run PassengerSeeder first.');
            return;
        }

        $statuses = ['Checked-In','Loaded','In-Transit','Arrived','Lost'];
        $remarks = [
            'Fragile', 'Handle with care', 'Heavy', 'Oversized', 'Contains electronics', 
            'Urgent delivery', 'Special handling required', 'Priority baggage'
        ];

        foreach ($passengers as $passenger) {
            $bags = rand(1, 3); // 1-3 bags per passenger

            for ($i = 0; $i < $bags; $i++) {
                Baggage::create([
                    'passenger_id' => $passenger->id,
                    'flight_id' => $passenger->flight_id,
                    'tag_number' => strtoupper(Str::random(3)) . rand(1000, 9999),
                    'status' => $statuses[array_rand($statuses)],
                    'weight' => rand(5, 30), // kg
                    'remarks' => $remarks[array_rand($remarks)],
                ]);
            }
        }
    }
}
