<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Models\Report;
use App\Models\Evidence;

class SaveReportData
{
    /**
     *
     * @param array
     * @return Report|null
     */
    public function call(array $data): ?Report
    {
        try {
            $report = Report::create([
                'user_id' => $data['user_id'],
                'traffic_light_id' => $data['traffic_light_id'],
                'description' => $data['description'],
                'status' => $data['status'],
                'comments' => $data['comments'] ?? null,
                'reported_at' => $data['reported_at'] ?? now(),
            ]);

            if (isset($data['evidences']) && is_array($data['evidences'])) {
                foreach ($data['evidences'] as $evidence) {
                    Evidence::create([
                        'report_id' => $report->id,
                        'file_path' => $evidence['file_path'],
                        'file_type' => $evidence['file_type'],
                    ]);
                }
            }

            Log::info("Reporte creado con éxito: {$report->id}");

            return $report;
        } catch (\Exception $e) {
            Log::error("Error al crear el reporte: {$e->getMessage()}");
            return null;
        }
    }
}
