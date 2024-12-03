<?php

namespace Database\Factories;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Otp>
 */
class OtpFactory extends Factory
{
    protected $model = Otp::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), // Genera un usuario relacionado automáticamente
            'otp_code' => $this->faker->numerify('######'), // Genera un código de 6 dígitos
            'expires_at' => now()->addMinutes(10), // Expira en 10 minutos
        ];
    }
}
