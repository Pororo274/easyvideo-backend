<?php

use App\Http\Controllers\VideoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(VideoController::class)->prefix('videos')->group(function () {
    Route::post('chunk', 'uploadChunk');
});
