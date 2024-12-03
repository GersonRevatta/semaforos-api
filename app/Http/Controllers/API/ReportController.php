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

  /**
   * @OA\Post(
   *     path="/v1/reports",
   *     summary="Crear un reporte",
   *     tags={"Reports"},
   *     security={{"api_key_security_example": {}}},
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             @OA\Property(property="traffic_light_id", type="integer", example=1),
   *             @OA\Property(property="description", type="string", example="Semáforo dañado"),
   *             @OA\Property(property="status", type="string", example="dañado"),
   *             @OA\Property(property="evidences", type="array", @OA\Items(
   *                 @OA\Property(property="file_path", type="string", example="/uploads/image.png"),
   *                 @OA\Property(property="file_type", type="string", example="image")
   *             ))
   *         )
   *     ),
   *     @OA\Response(response=201, description="Reporte creado con éxito"),
   *     @OA\Response(response=500, description="Error al crear el reporte")
   * )
   */
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

  /**
   * @OA\Get(
   *     path="/v1/reports/my",
   *     summary="Listar mis reportes",
   *     tags={"Reports"},
   *     security={{"api_key_security_example": {}}},
   *     @OA\Response(response=200, description="Lista de reportes del usuario"),
   *     @OA\Response(response=401, description="Usuario no autenticado")
   * )
   */
  public function myReports()
  {
    $reports = Report::where('user_id', Auth::id())->with('trafficLight', 'evidences')->get();
    return ReportResource::collection($reports);
  }

  /**
   * @OA\Get(
   *     path="/v1/traffic-lights/nearby",
   *     summary="Semáforos cercanos",
   *     tags={"Reports"},
   *     security={{"api_key_security_example": {}}},
   *     @OA\Parameter(
   *         name="latitude",
   *         in="query",
   *         description="Latitud actual del usuario",
   *         required=true,
   *         @OA\Schema(type="number", example=-12.0464)
   *     ),
   *     @OA\Parameter(
   *         name="longitude",
   *         in="query",
   *         description="Longitud actual del usuario",
   *         required=true,
   *         @OA\Schema(type="number", example=-77.0428)
   *     ),
   *     @OA\Parameter(
   *         name="radius",
   *         in="query",
   *         description="Radio en kilómetros para buscar semáforos",
   *         required=true,
   *         @OA\Schema(type="number", example=5)
   *     ),
   *     @OA\Response(response=200, description="Lista de semáforos cercanos"),
   *     @OA\Response(response=401, description="Usuario no autenticado")
   * )
   */
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
