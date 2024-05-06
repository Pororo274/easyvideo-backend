<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\VideoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(VideoController::class)->prefix('videos')->group(function () {
    Route::post('chunk', 'uploadChunk');
    Route::post('render', 'render');
});

Route::controller(ProjectController::class)->prefix('projects')->group(function () {
    Route::post('', 'create');
    Route::post('render', 'render');
});

Route::controller(\App\Http\Controllers\MediaController::class)->prefix('media')->group(function () {
    Route::post('chunk', 'storeChunk');
});
