<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'traffic_light_id', 'description', 'status', 'comments', 'reported_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trafficLight()
    {
        return $this->belongsTo(TrafficLight::class);
    }

    public function evidences()
    {
        return $this->hasMany(Evidence::class);
    }
}
