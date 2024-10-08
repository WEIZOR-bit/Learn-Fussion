<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerifyController;
use Illuminate\Support\Facades\Route;

Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:user');
Route::get('/validate-token', [AuthController::class, 'validateToken']);
Route::get('/me', [AuthController::class, 'me']);




Route::patch('/verify/{id}/{hash}', [EmailVerifyController::class, 'verify'])->name('verification.verify');


