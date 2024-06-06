<?php

namespace App\Contracts\Repositories;

use App\Dto\User\CreateUserDto;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryContract
{
    public function store(CreateUserDto $dto): User;
    public function findById(int $userId): User;
    public function findAllUnreadNotificationsByUserId(int $userId): Collection;
    public function markNotificationAsRead(int $userId, string $notificationId): void;
}
