<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\SubscriptionRepositoryContract;
use App\Contracts\Services\UserServiceContract;
use App\Dto\User\UserBriefDto;
use App\Dto\User\UserDto;
use App\Enums\User\UserRoleEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function findAllNotifications(int $userId, UserServiceContract $userService): JsonResponse
    {
        $notifications = $userService->findAllUnreadNotificationsByUserId($userId);

        return response()->json($notifications);
    }

    public function markAsReadNotification(int $userId, string $notificationId, UserServiceContract $userService): JsonResponse
    {
        $userService->markNotificationAsRead($userId, $notificationId);

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function getBriefByUserId(int $userId, UserServiceContract $userService): JsonResponse
    {
        return response()->json($userService->getUserBriefByUserId($userId));
    }

    public function getAllUsers(UserServiceContract $userService, SubscriptionRepositoryContract $subscriptionRepo): JsonResponse
    {
        $users = $userService->all()->filter(function (User $user) {
            return !collect($user->roles)->contains(UserRoleEnum::ADMIN->value);
        })->map(function (User $user) use ($subscriptionRepo) {
            try {
                $subscriptionRepo->findLastActiveByUserId($user->id);
                $subscription = true;
            } catch (ModelNotFoundException) {
                $subscription = false;
            }
            return new UserDto(
                id: $user->id,
                email: $user->email,
                username: $user->username,
                subscription: $subscription,
                createdAt: $user->created_at
            );
        });

        return response()->json($users);
    }

    public function getUser(int $userId): JsonResponse
    {
        $user = User::query()->find($userId);

        return response()->json($user);
    }
}
