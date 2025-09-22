<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Airline;

class AirlineSeeder extends Seeder
{
    public function run(): void
    {
        $airlines = [
            [
                'name' => 'RwandAir',
                'code' => 'RWA',
                'country' => 'Rwanda',
                'contact_email' => 'info@rwandair.com',
                'contact_phone' => '+250788123456',
            ],
            [
                'name' => 'Ethiopian Airlines',
                'code' => 'ETH',
                'country' => 'Ethiopia',
                'contact_email' => 'info@ethiopianairlines.com',
                'contact_phone' => '+251114123456',
            ],
            [
                'name' => 'Kenya Airways',
                'code' => 'KQA',
                'country' => 'Kenya',
                'contact_email' => 'info@kenya-airways.com',
                'contact_phone' => '+254711123456',
            ],
            [
                'name' => 'Turkish Airlines',
                'code' => 'THY',
                'country' => 'Turkey',
                'contact_email' => 'info@turkishairlines.com',
                'contact_phone' => '+90 212 444 0849',
            ],
            [
                'name' => 'Qatar Airways',
                'code' => 'QTR',
                'country' => 'Qatar',
                'contact_email' => 'info@qatarairways.com',
                'contact_phone' => '+974 4449 9999',
            ],
        ];

        foreach ($airlines as $airline) {
            Airline::create($airline);
        }
    }
}
