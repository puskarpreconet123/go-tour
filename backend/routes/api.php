<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    
    // A simple test endpoint to verify the API is running
    Route::get('/ping', function () {
        return response()->json([
            'status' => 'success',
            'message' => 'Go Tour API v1 is running!',
            'environment' => config('app.env')
        ]);
    });

    Route::get('/destinations', [\App\Http\Controllers\Api\V1\DestinationController::class, 'index']);
    Route::get('/destinations/{id}', [\App\Http\Controllers\Api\V1\DestinationController::class, 'show']);

    Route::get('/bookings', [\App\Http\Controllers\Api\V1\BookingController::class, 'index']);
    Route::post('/bookings', [\App\Http\Controllers\Api\V1\BookingController::class, 'store']);
    Route::get('/bookings/{id}', [\App\Http\Controllers\Api\V1\BookingController::class, 'show']);
});
