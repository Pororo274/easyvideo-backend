<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryContract;
use App\Dto\User\CreateUserDto;
use App\Models\User;

class UserRepository implements UserRepositoryContract
{

    public function store(CreateUserDto $dto): User
    {
        return User::query()->create([
            'username' => $dto->username,
            'password' => $dto->password,
            'email' => $dto->email
        ]);
    }
}
