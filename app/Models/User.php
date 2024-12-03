<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = ['name', 'last_name', 'email', 'password', 'nickname', 'status', 'dni'];

    protected $hidden = ['password'];

    protected $attributes = [
      'status' => 'pending_validation',
  ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function otps()
    {
      return $this->hasMany(Otp::class);
    }
}
