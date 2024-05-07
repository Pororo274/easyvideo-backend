<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

final class LoginInvalidCredentialsException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'message' => 'Неверный логин с почтой или пароль'
        ], 422);
    }
}
