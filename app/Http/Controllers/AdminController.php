<?php

namespace App\Http\Controllers;

use App\Contracts\Services\MediaServiceContract;
use App\Contracts\Services\UserServiceContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function getBrief(MediaServiceContract $mediaService, UserServiceContract $userService)
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
}
