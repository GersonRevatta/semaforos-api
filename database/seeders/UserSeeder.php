<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'John',
                'last_name' => 'Doe',
                'email' => 'gersonrevatta@gmail.com',
                'password' => Hash::make('gerson'),
                'dni' => '12345678',
                'nickname' => 'johndoe',
                'status' => 'validated',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane.smith@example.com',
                'password' => Hash::make('password123'),
                'dni' => '87654321',
                'nickname' => 'janesmith',
                'status' => 'pending_validation',
                'email_verified_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
