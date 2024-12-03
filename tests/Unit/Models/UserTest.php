<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Otp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_has_otps()
    {
        $user = User::factory()->create();
        $otps = Otp::factory()->count(3)->create(['user_id' => $user->id]);

        foreach ($otps as $otp) {
            $this->assertTrue($user->otps->contains($otp));
        }
        $this->assertCount(3, $user->otps);
    }

    /** @test */
    public function user_has_correct_attributes()
    {
        $user = User::factory()->make();

        $this->assertNotEmpty($user->name);
        $this->assertNotEmpty($user->last_name);
        $this->assertNotEmpty($user->email);
        $this->assertNotEmpty($user->password);
        $this->assertNotEmpty($user->nickname);
        $this->assertNotEmpty($user->dni);

        $this->assertContains($user->status, ['pending_validation', 'validated']);
    }

    /** @test */
    public function user_can_be_persisted_in_database()
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $user->email,
            'nickname' => $user->nickname,
        ]);
    }
}
