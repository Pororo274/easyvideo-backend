<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VirtualMediaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(ProjectController::class)->middleware('auth:sanctum')->group(function () {
    Route::prefix('users/{userId}/projects')->group(function () {
        Route::get('', 'getAllByUserId');
    });

    Route::prefix('projects')->group(function () {
        Route::post('', 'create');
        Route::get('configs', 'getConfigs');
        Route::get('/download/{filename}', 'downloadOutputFile');
        Route::post('{projectId}/render', 'render');
        Route::get('{projectId}', 'findById');
        Route::delete('{projectId}', 'deleteById');
    });
});

Route::controller(MediaController::class)->middleware('auth:sanctum')->group(function () {
    Route::prefix('projects/{projectId}/media')->group(function () {
        Route::get('', 'findAllByProjectId');
    });

    Route::prefix('media')->withoutMiddleware('auth:sanctum')->group(function () {
        Route::post('chunk', 'storeChunk');
        Route::get('{mediaName}', 'getMedia');
    });
});

Route::controller(VirtualMediaController::class)->group(function () {
    Route::prefix('projects/{projectId}/virtual-media')->group(function () {
        Route::get('', 'findAllByProjectId');
        Route::post('sync', 'sync');
    });
});

Route::controller(UserController::class)->prefix('users')->group(function () {
    Route::get('{userId}/notifications', 'findAllNotifications');
    Route::post('{userId}/notifications/{notificationId}/mark', 'markAsReadNotification');
});

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::post('sign-up', 'signUp');
        Route::post('login', 'login');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', 'logout');
    });
});

Route::controller(SubscriptionController::class)->prefix('subscriptions')->group(function () {
    Route::post('month', 'createMonthSubscription');
});
