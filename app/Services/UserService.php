<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryContract;
use App\Contracts\Services\UserServiceContract;
use App\Dto\User\CreateUserDto;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService implements UserServiceContract
{

    public function __construct(
        protected UserRepositoryContract $userRepo
    )
    {}

    public function signUp(CreateUserDto $dto): User
    {
        $user = $this->userRepo->store($dto);

        Auth::login($user);

        return $user;
    }
}
