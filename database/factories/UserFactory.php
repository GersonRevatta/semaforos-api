<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'), // O usa Hash::make()
            'nickname' => $this->faker->userName(),
            'dni' => $this->faker->numerify('########'),
            'status' => $this->faker->randomElement(['pending_validation', 'validated']),
        ];
    }
}
