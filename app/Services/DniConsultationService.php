<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Responses\DniConsultationResponse;

class DniConsultationService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
      $this->baseUrl = 'https://apiperu.dev/api/dni/';
      $this->apiKey = env('API_PERU_KEY', '30870a670c1d3850c6b9dc282bea99d0e74cfcd06872a6a5029cec53a98ab252');
    }

    public function consultDni(string $dni): DniConsultationResponse
    {
        try {
            $headers = [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
            ];

            $params = [
                'dni' => $dni,
            ];

            $response = Http::withHeaders($headers)
                ->post($this->baseUrl, $params);

            if ($response->successful()) {
                Log::info("Consulta exitosa para el DNI: $dni");

                return new DniConsultationResponse(
                    success: true,
                    data: $response->json()
                );
            } else {
                Log::error("Error al consultar el DNI: $dni", [
                    'status'  => $response->status(),
                    'message' => $response->body(),
                ]);

                return new DniConsultationResponse(
                    success: false,
                    message: 'Error en la consulta',
                    status: $response->status()
                );
            }
        } catch (\Exception $e) {
            Log::error("Excepción al consultar el DNI: {$e->getMessage()}");

            return new DniConsultationResponse(
                success: false,
                message: 'Error inesperado: ' . $e->getMessage()
            );
        }
    }
}
