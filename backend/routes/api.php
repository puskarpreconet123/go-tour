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

    // Auth Routes
    Route::post('/auth/register', [\App\Http\Controllers\Api\V1\AuthController::class, 'register']);
    Route::post('/auth/login', [\App\Http\Controllers\Api\V1\AuthController::class, 'login']);

    // Destinations
    Route::get('/destinations', [\App\Http\Controllers\Api\V1\DestinationController::class, 'index']);
    Route::get('/destinations/{id}', [\App\Http\Controllers\Api\V1\DestinationController::class, 'show']);

    // Protected Routes
    Route::middleware([\App\Http\Middleware\ApiAuthMiddleware::class])->group(function () {
        // Bookings
        Route::get('/bookings', [\App\Http\Controllers\Api\V1\BookingController::class, 'index']);
        Route::post('/bookings', [\App\Http\Controllers\Api\V1\BookingController::class, 'store']);
        Route::get('/bookings/{id}', [\App\Http\Controllers\Api\V1\BookingController::class, 'show']);

        // Support & Visa/Passport Requests
        Route::get('/requests', [\App\Http\Controllers\Api\V1\RequestController::class, 'index']);
        Route::post('/requests', [\App\Http\Controllers\Api\V1\RequestController::class, 'store']);
    });

    // Setup DB without session middleware crashing it!
    Route::get('/setup-db', function () {
        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            return response()->json([
                'status' => 'success',
                'message' => 'Database migrations ran successfully!',
                'output' => \Illuminate\Support\Facades\Artisan::output()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    });

    // Create a default admin user for testing
    Route::get('/setup-admin', function () {
        $admin = \App\Models\User::firstOrCreate(
            ['email' => 'admin@gotour.com'],
            [
                'name' => 'Admin User',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'admin'
            ]
        );
        return response()->json([
            'status' => 'success',
            'message' => 'Admin user created successfully!',
            'credentials' => [
                'email' => 'admin@gotour.com',
                'password' => 'password123'
            ]
        ]);
    });

    // Seed dummy data
    Route::get('/seed-dummy-data', function () {
        try {
            \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
            return response()->json([
                'status' => 'success',
                'message' => 'Dummy data seeded successfully!', 
                'output' => \Illuminate\Support\Facades\Artisan::output()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    });
});
