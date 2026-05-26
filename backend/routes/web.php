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

