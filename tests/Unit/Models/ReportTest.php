<?php

namespace Tests\Unit;

use App\Models\Evidence;
use App\Models\Report;
use App\Models\TrafficLight;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function report_belongs_to_a_user()
    {
        $user = User::factory()->create();

        $report = Report::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $report->user);
        $this->assertEquals($user->id, $report->user->id);
    }

    /** @test */
    public function report_belongs_to_a_traffic_light()
    {
        $trafficLight = TrafficLight::factory()->create();

        $report = Report::factory()->create(['traffic_light_id' => $trafficLight->id]);

        $this->assertInstanceOf(TrafficLight::class, $report->trafficLight);
        $this->assertEquals($trafficLight->id, $report->trafficLight->id);
    }

    /** @test */
    public function report_has_many_evidences()
    {
        $report = Report::factory()->create();

        $evidences = Evidence::factory()->count(3)->create(['report_id' => $report->id]);

        $this->assertCount(3, $report->evidences);
        foreach ($evidences as $evidence) {
            $this->assertTrue($report->evidences->contains($evidence));
        }
    }

    /** @test */
    public function report_has_correct_attributes()
    {
        $report = Report::factory()->make();

        $this->assertNotEmpty($report->description);
        $this->assertContains($report->status, ['funcionando', 'dañado', 'intermitente']);
        $this->assertNotEmpty($report->reported_at);
    }

    /** @test */
    public function report_can_be_persisted_in_database()
    {
        $report = Report::factory()->create();

        $this->assertDatabaseHas('reports', [
            'id' => $report->id,
            'user_id' => $report->user_id,
            'traffic_light_id' => $report->traffic_light_id,
            'description' => $report->description,
            'status' => $report->status,
            'reported_at' => $report->reported_at,
        ]);
    }
}
