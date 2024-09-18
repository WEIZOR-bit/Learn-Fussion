<?php

use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

Route::get('/profile', function () {
    // Only verified users may access this route...
    Route::post('/view', [\App\Http\Controllers\CourseController::class, 'index'])->middleware('auth:user');
})->middleware(['auth', 'verified']);

Route::resource('courses', CourseController::class)->middleware('auth:user');
