<?php

use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:user', 'verified'])->group(function () {
    Route::resource('courses', CourseController::class);
    Route::resource('lessons', LessonController::class)->except(['create', 'edit']);
    Route::resource('questions', QuestionController::class)->except(['create', 'edit']);
    Route::resource('homeworks', HomeworkController::class)->except(['create', 'edit']);
    Route::resource('challenges', ChallengeController::class)->except(['create', 'edit']);

    Route::resource('users', UserController::class)->except(['create', 'edit']);

    Route::get('users/{id}/mastery-level', [UserController::class, 'getMasteryLevel']);
    Route::get('users/{id}/league', [UserController::class, 'getLeague']);
    Route::get('users/{id}/streak', [UserController::class, 'getStreakDays']);
    Route::patch('users/{id}/activity', [UserController::class, 'updateActivity']);
});

