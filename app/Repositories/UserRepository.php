<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryContract;
use App\Dto\User\CreateUserDto;
use App\Enums\User\UserStatusEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryContract
{

    public function store(CreateUserDto $dto): User
    {
        return User::query()->create([
            'username' => $dto->username,
            'password' => $dto->password,
            'email' => $dto->email,
            'roles' => $dto->roles
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

    public function markNotificationAsRead(int $userId, string $notificationId): void
    {
        $user = $this->findById($userId);

        foreach ($user->unreadNotifications as $notification) {
            if ($notification->id === $notificationId) {
                $notification->markAsRead();
                break;
            }
        }
    }

    public function getTotalUsersCount(): int
    {
        return User::query()->count();
    }

    public function all(): Collection
    {
        return User::query()->get();
    }

    public function banByUserId(int $userId): User
    {
        User::query()->where('id', $userId)->update([
            'status' => UserStatusEnum::Banned
        ]);

        return $this->findById($userId);
    }
}
