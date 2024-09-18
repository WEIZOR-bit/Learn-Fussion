<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use Illuminate\Support\Facades\Route;

Route::resource('courses', CourseController::class)->middleware(['auth:admin']);
Route::resource('lessons', LessonController::class)->middleware(['auth:admin']);


