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

    public function banByUserId(int $userId, UserServiceContract $userService): JsonResponse
    {
        $user = $userService->banByUserId($userId);

        return response()->json($user);
    }
}
