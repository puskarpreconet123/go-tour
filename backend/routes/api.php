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

    // We will add Auth, Destinations, and Bookings here next!
});
