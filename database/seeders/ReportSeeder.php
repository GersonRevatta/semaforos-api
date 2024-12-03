<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Report;
use App\Models\User;
use App\Models\TrafficLight;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $firstUser = User::first();
        $firstTrafficLight = TrafficLight::first();

        if (!$firstUser || !$firstTrafficLight) {
            $this->command->warn('No se encontraron usuarios o semáforos disponibles. El seeder no pudo ejecutarse.');
            return;
        }

        Report::insert([
            [
                'user_id' => $firstUser->id,
                'traffic_light_id' => $firstTrafficLight->id,
                'description' => 'El semáforo no enciende en ninguna de sus luces.',
                'status' => 'funcionando',
                'comments' => 'Se necesita inspección urgente.',
                'reported_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $firstUser->id,
                'traffic_light_id' => $firstTrafficLight->id,
                'description' => 'El semáforo está en modo intermitente.',
                'status' => 'funcionando',
                'comments' => 'Posiblemente por un corte de energía.',
                'reported_at' => now()->subDays(1),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $firstUser->id,
                'traffic_light_id' => $firstTrafficLight->id,
                'description' => 'El semáforo funciona correctamente.',
                'status' => 'funcionando',
                'comments' => 'Sin problemas reportados.',
                'reported_at' => now()->subDays(2),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
