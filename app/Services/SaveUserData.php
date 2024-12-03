<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Models\User;

class SaveUserData
{
    /**
     *
     * @param User
     * @param array
     * @return void
     */
    public function call(User $user, array $response): void
    {
      try {
        if (isset($response['success']) && $response['success'] === true) {
            $data = $response['data'] ?? [];

            $user->name = $data['nombres'] ?? $user->name;
            $user->last_name = trim(($data['apellido_paterno'] ?? '') . ' ' . ($data['apellido_materno'] ?? ''));
            $user->save();
            Log::info("Usuario actualizado correctamente: {$user->id}");
        } else {
            Log::warning("La respuesta no fue exitosa: ", $response);
        }
      } catch (\Exception $e) {
          Log::error("Error al actualizar el usuario: {$e->getMessage()}");
      }
    }
}
