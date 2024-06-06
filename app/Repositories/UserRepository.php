<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryContract;
use App\Dto\User\CreateUserDto;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

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

    public function findById(int $userId): User
    {
        return User::query()->findOrFail($userId);
    }

    public function findAllUnreadNotificationsByUserId(int $userId): Collection
    {
        return $this->findById($userId)->unreadNotifications;
    }
}
