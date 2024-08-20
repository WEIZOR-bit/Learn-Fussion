<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:user');
Route::post('/view', [\App\Http\Controllers\CourseController::class, 'index'])->middleware('auth:user');
Route::post('/store', [\App\Http\Controllers\CourseController::class, 'store'])->middleware('auth:user');
