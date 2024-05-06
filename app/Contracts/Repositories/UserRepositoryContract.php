<?php

namespace App\Contracts\Repositories;

use App\Dto\User\CreateUserDto;
use App\Models\User;

interface UserRepositoryContract
{
    public function store(CreateUserDto $dto): User;
}
