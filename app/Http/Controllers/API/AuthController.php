<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Services\DniConsultationService;
use App\Services\SaveUserData;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Otp;

use Carbon\Carbon;
use JWTAuth;

class AuthController extends Controller
{

  /**
   * @OA\Post(
   *     path="/v1/auth/login",
   *     summary="Inicio de sesión",
   *     tags={"Auth"},
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             @OA\Property(property="email", type="string", example="user@example.com"),
   *             @OA\Property(property="password", type="string", example="password")
   *         )
   *     ),
   *     @OA\Response(response=200, description="Token de acceso generado"),
   *     @OA\Response(response=401, description="Credenciales inválidas")
   * )
   */
  public function login(Request $request)
  {
    $credentials = $request->only('email', 'password');
    if (!$token = JWTAuth::attempt($credentials)) {
      return response()->json(['error' => 'Unauthorized'], 401);
    }

    return response()->json(['token' => $token]);
  }


  /**
   * @OA\Post(
   *     path="/v1/auth/register",
   *     summary="Registro de usuario",
   *     tags={"Auth"},
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             @OA\Property(property="email", type="string", example="user@example.com"),
   *             @OA\Property(property="password", type="string", example="password"),
   *             @OA\Property(property="nickname", type="string", example="user123"),
   *             @OA\Property(property="dni", type="string", example="12345678")
   *         )
   *     ),
   *     @OA\Response(response=201, description="Usuario registrado con éxito"),
   *     @OA\Response(response=500, description="Error durante el registro")
   * )
   */
  public function register(Request $request)
  {
    try {
      $user = $this->createUser($request);
      $otpCode = $this->generateOtp($user);
      $this->sendOtpEmail($user, $otpCode);
      $this->processDni($user);
      return response()->json(['message' => 'Usuario registrado. Revisa tu correo para verificar tu cuenta.'], 201);
    } catch (\Exception $e) {
      Log::error("Error al registrar usuario: {$e->getMessage()}");
      return response()->json(['message' => 'Ocurrió un error durante el registro.'], 500);
    }
  }

  private function createUser(Request $request)
  {
    return User::create([
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'nickname' => $request->nickname,
      'dni' => $request->dni,
    ]);
  }

  private function generateOtp(User $user)
  {
    $otpCode = rand(100000, 999999);
    Otp::create([
      'user_id' => $user->id,
      'otp_code' => $otpCode,
      'expires_at' => Carbon::now()->addMinutes(10),
    ]);
    return $otpCode;
  }

  private function sendOtpEmail(User $user, $otpCode)
  {
    Mail::raw("Tu código OTP es: $otpCode. Verifícalo haciendo clic en el siguiente enlace: " . 
        url("auth/verify-otp?email={$user->email}&otp_code={$otpCode}"),
        function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Verificación de correo electrónico');
        });
  }

  private function processDni(User $user)
  {
    $dniService = new DniConsultationService();
    $response = $dniService->consultDni($user->dni);

    if ($response->success) {
      $saveUserDataService = new SaveUserData();
      $saveUserDataService->call($user, $response->data);
    } else {
      Log::warning("No se pudieron actualizar los datos del usuario debido a una consulta fallida.");
    }
  }
}
