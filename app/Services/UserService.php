<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryContract;
use App\Contracts\Services\UserServiceContract;
use App\Dto\Auth\LoginUserDto;
use App\Dto\User\CreateUserDto;
use App\Dto\User\UsersBriefDto;
use App\Exceptions\LoginInvalidCredentialsException;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
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

    public function findAllUnreadNotificationsByUserId(int $userId): Collection
    {
        return $this->userRepo->findAllUnreadNotificationsByUserId($userId);
    }

    public function markNotificationAsRead(int $userId, string $notificationId): void
    {
        $this->userRepo->markNotificationAsRead($userId, $notificationId);
    }

    public function getUsersBrief(): UsersBriefDto
    {
        return new UsersBriefDto(
            total: $this->userRepo->getTotalUsersCount(),
            totalWithSubscription: 0,
            totalBanned: 0
        );
    }
}
