<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\VideoController;
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
        Route::post('render', 'render');
        Route::get('{projectId}', 'findById');
    });
});

Route::controller(MediaController::class)->middleware('auth:sanctum')->group(function () {
    Route::prefix('projects/{projectId}/media')->group(function () {
        Route::get('', 'findAllByProjectId');
    });

    Route::prefix('media')->group(function () {
        Route::post('chunk', 'storeChunk');
        Route::get('{mediaName]', 'getMedia');
    });
});

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('sign-up', 'signUp');
    Route::post('login', 'login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', 'logout');
    });
});
