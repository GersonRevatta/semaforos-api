<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TrafficLight;

class TrafficLightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TrafficLight::insert([
            [
                'latitude' => '-12.043180',
                'longitude' => '-77.028240',
                'type' => 'vehicular',
                'department' => 'Lima',
                'district' => 'Miraflores',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'latitude' => '-12.046374',
                'longitude' => '-77.042793',
                'type' => 'peatonal',
                'department' => 'Lima',
                'district' => 'San Isidro',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'latitude' => '-12.070580',
                'longitude' => '-77.034518',
                'type' => 'mixto',
                'department' => 'Lima',
                'district' => 'Barranco',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
