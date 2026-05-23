<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'dashboard']);
Route::get('/admin/bookings', [\App\Http\Controllers\AdminController::class, 'bookings']);
Route::get('/admin/requests', [\App\Http\Controllers\AdminController::class, 'requests']);


