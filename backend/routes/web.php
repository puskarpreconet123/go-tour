<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/admin/login', [\App\Http\Controllers\AdminController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [\App\Http\Controllers\AdminController::class, 'login']);
Route::post('/admin/logout', [\App\Http\Controllers\AdminController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'dashboard']);
    Route::get('/admin/bookings', [\App\Http\Controllers\AdminController::class, 'bookings']);
    Route::post('/admin/bookings/{id}/status', [\App\Http\Controllers\AdminController::class, 'updateBookingStatus']);
    Route::get('/admin/requests', [\App\Http\Controllers\AdminController::class, 'requests']);
    Route::post('/admin/requests/{id}/status', [\App\Http\Controllers\AdminController::class, 'updateRequestStatus']);
    Route::get('/admin/users', [\App\Http\Controllers\AdminController::class, 'users']);
    Route::get('/admin/tours', [\App\Http\Controllers\AdminController::class, 'tours']);
    Route::post('/admin/tours', [\App\Http\Controllers\AdminController::class, 'storeTour']);
    Route::post('/admin/tours/{id}/update', [\App\Http\Controllers\AdminController::class, 'updateTour']);
    Route::post('/admin/tours/{id}/delete', [\App\Http\Controllers\AdminController::class, 'deleteTour']);
    Route::get('/admin/cms', [\App\Http\Controllers\AdminController::class, 'cms']);
    Route::post('/admin/cms/update', [\App\Http\Controllers\AdminController::class, 'updateCms'])->name('admin.cms.update');
    Route::get('/admin/win-trip', [\App\Http\Controllers\AdminController::class, 'winTrip']);
});

// Fallback image serving route when symlink fails in cloud environments
Route::get('/storage/uploads/tours/{filename}', function ($filename) {
    $path = storage_path('app/public/uploads/tours/' . $filename);
    if (!file_exists($path)) {
        abort(404);
    }
    $file = file_get_contents($path);
    $type = mime_content_type($path);
    return response($file)->header('Content-Type', $type);
});

// Dynamic serving endpoint that bypasses static asset overrides by webservers
Route::get('/tours/media', function (\Illuminate\Http\Request $request) {
    $file = $request->query('file');
    $path = storage_path('app/public/uploads/tours/' . basename($file));
    if (!file_exists($path)) {
        abort(404);
    }
    $fileContent = file_get_contents($path);
    $type = mime_content_type($path);
    return response($fileContent)->header('Content-Type', $type);
});

