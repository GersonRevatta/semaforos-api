<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrafficLightResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
      return [
        'id' => $this->id,
        'latitude' => $this->latitude,
        'longitude' => $this->longitude,
        'type' => $this->type,
        'department' => $this->department,
        'district' => $this->district,
        'updated_at' => $this->updated_at->toDateTimeString(),
      ];
    }
}
