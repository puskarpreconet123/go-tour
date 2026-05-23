<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/admin/login', [\App\Http\Controllers\AdminController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [\App\Http\Controllers\AdminController::class, 'login']);
Route::post('/admin/logout', [\App\Http\Controllers\AdminController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'dashboard']);
    Route::get('/admin/bookings', [\App\Http\Controllers\AdminController::class, 'bookings']);
    Route::get('/admin/requests', [\App\Http\Controllers\AdminController::class, 'requests']);
    Route::get('/admin/users', [\App\Http\Controllers\AdminController::class, 'users']);
});


