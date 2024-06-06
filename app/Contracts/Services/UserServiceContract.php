<?php

namespace App\Contracts\Services;

use App\Dto\Auth\LoginUserDto;
use App\Dto\User\CreateUserDto;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserServiceContract
{
    public function signUp(CreateUserDto $dto): User;
    public function login(LoginUserDto $dto): User;
    public function logout(): void;
    public function findAllUnreadNotificationsByUserId(int $userId): Collection;
}
