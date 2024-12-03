<?php

namespace Database\Factories;

use App\Models\Evidence;
use App\Models\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

class EvidenceFactory extends Factory
{
    protected $model = Evidence::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'report_id' => Report::factory(), // Crea un reporte relacionado
            'file_path' => $this->faker->filePath(), // Ruta ficticia del archivo
            'file_type' => $this->faker->randomElement(['image', 'video']), // Tipo de archivo
        ];
    }
}
