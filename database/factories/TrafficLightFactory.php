<?php

namespace Database\Factories;

use App\Models\TrafficLight;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrafficLightFactory extends Factory
{
    protected $model = TrafficLight::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'latitude' => $this->faker->latitude(-90, 90), // Latitud válida
            'longitude' => $this->faker->longitude(-180, 180), // Longitud válida
            'type' => $this->faker->randomElement(['vehicular', 'peatonal', 'mixto']),
            'department' => $this->faker->state(), // Departamento o estado ficticio
            'district' => $this->faker->city(), // Distrito o ciudad ficticia
        ];
    }
}
