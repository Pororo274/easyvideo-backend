<?php

namespace App\Http\Controllers;

use App\Contracts\Services\MediaServiceContract;
use App\Contracts\Services\UserServiceContract;
use App\Enums\User\UserRoleEnum;
use App\Models\User;
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
                'totalAvailableSpace' => 104_857_600
            ],
            'users' => $userService->getUsersBrief()
        ]);
    }

    public function getAllUsers(UserServiceContract $userService): JsonResponse
    {
        $users = $userService->all()->filter(function (User $user) {
            return !collect($user->roles)->contains(UserRoleEnum::ADMIN->value);
        });

        return response()->json($users);
    }

    public function banByUserId(int $userId, UserServiceContract $userService): JsonResponse
    {
        $user = $userService->banByUserId($userId);

        return response()->json($user);
    }
}
