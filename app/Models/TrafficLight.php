<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrafficLight extends Model
{
    use HasFactory;

    protected $fillable = ['latitude', 'longitude', 'type', 'department', 'district'];

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
