<?php

namespace Tests\Unit;

use App\Models\Evidence;
use App\Models\Report;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EvidenceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function evidence_belongs_to_a_report()
    {
        $report = Report::factory()->create();

        $evidence = Evidence::factory()->create(['report_id' => $report->id]);

        $this->assertInstanceOf(Report::class, $evidence->report);
        $this->assertEquals($report->id, $evidence->report->id);
    }

    /** @test */
    public function evidence_has_correct_attributes()
    {
        $evidence = Evidence::factory()->make();

        $this->assertNotEmpty($evidence->file_path);
        $this->assertContains($evidence->file_type, ['image', 'video']);
    }

    /** @test */
    public function evidence_can_be_persisted_in_database()
    {
        $evidence = Evidence::factory()->create();

        $this->assertDatabaseHas('evidences', [
            'id' => $evidence->id,
            'report_id' => $evidence->report_id,
            'file_path' => $evidence->file_path,
            'file_type' => $evidence->file_type,
        ]);
    }
}
