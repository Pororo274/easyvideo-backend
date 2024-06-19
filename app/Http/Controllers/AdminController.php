<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\SubscriptionRepositoryContract;
use App\Contracts\Services\MediaServiceContract;
use App\Contracts\Services\UserServiceContract;
use App\Dto\User\UserDto;
use App\Enums\User\UserRoleEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function getBrief(MediaServiceContract $mediaService, UserServiceContract $userService): JsonResponse
    {
        $usedDiskSpace = $mediaService->getTotalSize();

        Log::info($usedDiskSpace);

        return response()->json([
            'disk' => [
                'usedSpace' => $usedDiskSpace,
                'totalAvailableSpace' => config('app.storage_space') * 1024 * 1024 * 1024
            ],
            'users' => $userService->getUsersBrief()
        ]);
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

        return response()->json($users->toArray());
    }

    public function banByUserId(int $userId, UserServiceContract $userService): JsonResponse
    {
        $user = $userService->banByUserId($userId);

        return response()->json($user);
    }
}
