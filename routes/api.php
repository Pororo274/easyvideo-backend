<?php

use App\Http\Controllers\AdminController;
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
        Route::get('file', 'getMedia');
    });
});

Route::controller(VirtualMediaController::class)->group(function () {
    Route::prefix('projects/{projectId}/virtual-media')->group(function () {
        Route::get('', 'findAllByProjectId');
        Route::post('sync', 'sync');
    });
});

Route::controller(UserController::class)->prefix('users')->group(function () {
    Route::get('all', 'getAllUsers');
    Route::get('{userId}/notifications', 'findAllNotifications');
    Route::post('{userId}/notifications/{notificationId}/mark', 'markAsReadNotification');
    Route::get('{userId}/brief', 'getBriefByUserId');
    Route::middleware('admin')->prefix('{userId}')->group(function () {
        Route::get('info', 'getUser');
    });
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

Route::controller(SubscriptionController::class)->group(function () {
    Route::prefix('users/{userId}/subscriptions')->group(function () {
        Route::get('last', 'findLast');
    });
    Route::prefix('subscriptions')->group(function () {
        Route::post('month', 'createMonthSubscription');
        Route::post('webhook', 'yookassaWebhook');
    });
});

Route::controller(AdminController::class)->prefix('admin')->middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('brief', 'getBrief');
    Route::patch('users/{userId}/ban', 'banByUserId');
    Route::get('folders/{folder}', 'App\Http\Controllers\MediaController@getFilesByFolder');
});
