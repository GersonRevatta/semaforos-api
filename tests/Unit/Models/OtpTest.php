<?php

namespace Tests\Unit;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OtpTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function otp_belongs_to_a_user()
    {
        $user = User::factory()->create();

        $otp = Otp::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $otp->user);
        $this->assertEquals($user->id, $otp->user->id);
    }

    /** @test */
    public function otp_has_correct_attributes()
    {
        $otp = Otp::factory()->make();

        $this->assertNotEmpty($otp->user_id);
        $this->assertNotEmpty($otp->otp_code);
        $this->assertNotEmpty($otp->expires_at);
    }

    /** @test */
    public function otp_can_be_persisted_in_database()
    {
        $otp = Otp::factory()->create();

        $this->assertDatabaseHas('otps', [
            'id' => $otp->id,
            'user_id' => $otp->user_id,
            'otp_code' => $otp->otp_code,
            'expires_at' => $otp->expires_at,
        ]);
    }

    /** @test */
    public function otp_expires_correctly()
    {
        $expiresAt = now()->addMinutes(10);
        $otp = Otp::factory()->create(['expires_at' => $expiresAt]);

        $this->assertEquals($expiresAt, $otp->expires_at);
        $this->assertTrue($otp->expires_at->greaterThanOrEqualTo(now()));
    }
}
