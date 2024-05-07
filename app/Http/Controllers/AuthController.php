<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserServiceContract;
use App\Dto\Auth\LoginUserDto;
use App\Dto\User\CreateUserDto;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\SignUpRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function signUp(SignUpRequest $request, UserServiceContract $userService): JsonResponse
    {
        $user = $userService->signUp(new CreateUserDto(
            email: $request->input('email'),
            password: $request->input('password'),
            username: $request->input('username')
        ));

        return response()->json($user);
    }

    public function login(LoginRequest $request, UserServiceContract $userService): JsonResponse
    {
        $user = $userService->login(new LoginUserDto(
            email: $request->input('email'),
            password: $request->input('password')
        ));

        return response()->json($user);
    }
}
