<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return view('welcome');
});

// Workaround for Render Free Tier (No Shell Access)
Route::get('/setup-db', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return response()->json([
            'status' => 'success',
            'message' => 'Database migrations ran successfully!',
            'output' => Artisan::output()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});
