<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryContract;
use App\Contracts\Services\UserServiceContract;
use App\Dto\Auth\LoginUserDto;
use App\Dto\User\CreateUserDto;
use App\Exceptions\LoginInvalidCredentialsException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService implements UserServiceContract
{

    public function __construct(
        protected UserRepositoryContract $userRepo
    ) {
    }

    public function signUp(CreateUserDto $dto): User
    {
        $user = $this->userRepo->store($dto);

        Auth::attempt([
            'email' => $dto->email,
            'password' => $dto->password
        ]);
        session()->regenerate();

        return $user;
    }

    public function login(LoginUserDto $dto): User
    {
        if (Auth::attempt([
            'email' => $dto->email,
            'password' => $dto->password
        ])) {
            session()->regenerate();

            return Auth::user();
        }

        throw new LoginInvalidCredentialsException();
    }

    public function logout(): void
    {
        Auth::guard("web")->logout();
    }
}
