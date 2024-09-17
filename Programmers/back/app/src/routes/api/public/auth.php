<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerifyController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:user');





Route::patch('/users/api/v1/users/verify/{id}/{hash}', [EmailVerifyController::class, 'verify'])->name('verification.verify');


