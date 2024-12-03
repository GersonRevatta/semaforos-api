<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evidence;
use App\Models\Report;

class EvidenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reports = Report::take(3)->pluck('id');

        if ($reports->count() < 3) {
            $this->command->warn('No hay suficientes reportes para insertar evidencia. Seeder no ejecutado.');
            return;
        }

        $evidences = [
            [
                'report_id' => $reports[0],
                'file_path' => 'uploads/evidences/damaged_traffic_light_1.jpg',
                'file_type' => 'image',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'report_id' => $reports[1],
                'file_path' => 'uploads/evidences/intermittent_traffic_light.mp4',
                'file_type' => 'video',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'report_id' => $reports[2],
                'file_path' => 'uploads/evidences/working_traffic_light.jpg',
                'file_type' => 'image',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Evidence::insert($evidences);
    }
}
