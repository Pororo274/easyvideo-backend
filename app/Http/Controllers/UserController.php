<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserServiceContract;
use App\Dto\User\UserBriefDto;
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
}
