<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Otp;

use Illuminate\Http\Request;

use Carbon\Carbon;

class AuthController extends Controller
{

  public function verifyOtpGet(Request $request)
  {
    try {
      $this->validateOtpRequest($request);
      $user = $this->findUserByEmail($request->email);
      $this->validateOtp($user, $request->otp_code);
      $this->markUserAsValidated($user);
      return view('auth.verify-otp', [
          'message' => 'OTP validado exitosamente. Usuario validado.'
      ]);
    } catch (\Exception $e) {
      return view('auth.verify-otp', [
          'message' => $e->getMessage()
      ]);
    }
  }
  
  private function validateOtpRequest(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
      'otp_code' => 'required',
    ]);
  }

  private function findUserByEmail(string $email): User
  {
    $user = User::where('email', $email)->first();

    if (!$user) {
        throw new \Exception('Usuario no encontrado.');
    }

    return $user;
  }
  
  private function validateOtp(User $user, string $otpCode)
  {
    $otp = Otp::where('user_id', $user->id)
              ->where('otp_code', $otpCode)
              ->where('expires_at', '>=', Carbon::now())
              ->first();

    if (!$otp) {
      throw new \Exception('OTP inválido o expirado.');
    }

    Otp::where('user_id', $user->id)->delete();
  }
  
  private function markUserAsValidated(User $user)
  {
    $user->status = 'validated';
    $user->save();
  }
}
