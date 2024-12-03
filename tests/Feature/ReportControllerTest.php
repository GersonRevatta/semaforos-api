<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_report_unauthenticated()
    {
        $data = [
            'traffic_light_id' => 1,
            'description' => 'Semáforo dañado',
            'status' => 'dañado',
            'evidences' => [
                ['file_path' => '/uploads/image1.png', 'file_type' => 'image'],
            ],
        ];

        $response = $this->postJson('/api/v1/reports', $data);

        $response->assertStatus(401)
                 ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function test_list_my_reports_unauthenticated()
    {
        $response = $this->getJson('/api/v1/reports/my');

        $response->assertStatus(401)
                 ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function test_nearby_traffic_lights_unauthenticated()
    {
        $response = $this->getJson('/api/v1/traffic-lights/nearby?latitude=-12.0464&longitude=-77.0428&radius=5');

        $response->assertStatus(401)
                 ->assertJson(['message' => 'Unauthenticated.']);
    }
}
