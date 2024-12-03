<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
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
            'user_id' => $this->user_id,
            'traffic_light' => [
                'id' => $this->trafficLight->id,
                'type' => $this->trafficLight->type,
                'department' => $this->trafficLight->department,
            ],
            'description' => $this->description,
            'status' => $this->status,
            'comments' => $this->comments,
            'reported_at' => $this->reported_at,
            'evidences' => $this->evidences->map(function ($evidence) {
                return [
                    'file_path' => $evidence->file_path,
                    'file_type' => $evidence->file_type,
                ];
            }),
        ];
    }
}
