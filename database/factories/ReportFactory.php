<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\User;
use App\Models\TrafficLight;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    protected $model = Report::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(), // Crea un usuario relacionado
            'traffic_light_id' => TrafficLight::factory(), // Crea un semáforo relacionado
            'description' => $this->faker->sentence(10), // Genera una descripción aleatoria
            'status' => $this->faker->randomElement(['funcionando', 'dañado', 'intermitente']),
            'comments' => $this->faker->optional()->paragraph(), // Comentarios opcionales
            'reported_at' => $this->faker->dateTimeBetween('-1 year', 'now'), // Fecha de reporte aleatoria
        ];
    }
}
