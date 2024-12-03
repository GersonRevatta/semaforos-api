<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;
use App\Http\Resources\TrafficLightResource;

use App\Models\Evidence;
use App\Models\Report;
use App\Models\TrafficLight;

use App\Services\TrafficLightService;
use App\Services\SaveReportData;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class ReportController extends Controller
{

  protected $saveReportData;

  public function __construct(SaveReportData $saveReportData)
  {
    $this->saveReportData = $saveReportData;
  }

  public function createReport(Request $request)
  {
    try {
      $request->validate([
        'traffic_light_id' => 'required|exists:traffic_lights,id',
        'description' => 'required|string',
        'status' => 'required|in:funcionando,dañado,intermitente',
        'comments' => 'nullable|string',
        'evidences' => 'nullable|array',
        'evidences.*.file_path' => 'required|string',
        'evidences.*.file_type' => 'required|in:image,video',
      ]);
      $data = $request->all();
      $data['user_id'] = Auth::id();
      $report = $this->saveReportData->call($data);
      if ($report) {
        return response()->json(['message' => 'Reporte creado con éxito', 'report' => $report], 201);
      } else {
        return response()->json(['message' => 'Error al crear el reporte.'], 500);
      }
    } catch (\Exception $e) {
      Log::error("Error al registrar reporte: {$e->getMessage()}");
      return response()->json(['message' => 'Ocurrió un error al agregar el reporte.'], 500);
    }
  }

  public function myReports()
  {
    $reports = Report::where('user_id', Auth::id())->with('trafficLight', 'evidences')->get();
    return ReportResource::collection($reports);
  }

  public function nearbyTrafficLights(Request $request)
  {
    $request->validate([
      'latitude' => 'required|numeric',
      'longitude' => 'required|numeric',
      'radius' => 'required|numeric', // Radio en kilómetros
    ]);

    $trafficLights = $this->trafficLightService->calculateNearbyTrafficLights(
      $request->latitude,
      $request->longitude,
      $request->radius
    );

    return TrafficLightResource::collection($trafficLights);
  }
}
