<?php

namespace App\Contracts\Services;

use App\Dto\User\CreateUserDto;
use App\Models\User;

interface UserServiceContract
{
    public function signUp(CreateUserDto $dto): User;
}
