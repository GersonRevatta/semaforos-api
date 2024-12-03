<?php

namespace App\Services;

use App\Models\TrafficLight;

class TrafficLightService
{
    /**
     * Calcula los semáforos cercanos.
     *
     * @param float $latitude Latitud del punto central.
     * @param float $longitude Longitud del punto central.
     * @param float $radius Radio de búsqueda
     * @return \Illuminate\Support\Collection Colección de semáforos cercanos.
     */
    public function calculateNearbyTrafficLights(float $latitude, float $longitude, float $radius)
    {
        return TrafficLight::selectRaw("id, latitude, longitude, type, department, district, 
                (6371 * acos(cos(radians(?)) 
                * cos(radians(latitude)) 
                * cos(radians(longitude) - radians(?)) 
                + sin(radians(?)) 
                * sin(radians(latitude)))) AS distance", [
                    $latitude, $longitude, $latitude
                ])
            ->having('distance', '<=', $radius)
            ->orderBy('distance', 'asc')
            ->get();
    }
}
