<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AirlineSeeder::class,
            FlightSeeder::class,
            PassengerSeeder::class,
            BaggageSeeder::class,
            UserSeeder::class,
            StaffSeeder::class
        ]);
    }
}
