<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChallengeCompletedController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\ChallengeUncheckedController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:admin'])->group(function () {
    Route::get('users/search', [UserController::class, 'search']);
    Route::resource('users', UserController::class)->except(['create', 'edit']);

    Route::get('users/{id}/mastery-level', [UserController::class, 'getMasteryLevel']);
    Route::get('users/{id}/league', [UserController::class, 'getLeague']);
    Route::get('users/{id}/streak', [UserController::class, 'getStreakDays']);
    Route::patch('users/{id}/activity', [UserController::class, 'updateActivity']);

    Route::post('admin/{id}/avatar', [AdminController::class, 'updateAvatar']);
    Route::get('admin/{id}', [AdminController::class, 'getAdmin']);



    Route::resource('courses', CourseController::class)->except(['create', 'edit']);
    Route::post('/courses/{id}/publish', [CourseController::class, 'publish']);

    Route::resource('categories', CategoryController::class)->except(['create', 'edit']);
    Route::post('/courses/{course}/lessons', [CourseController::class, 'addLessons']);
    Route::post('/lessons/{lesson}/questions', [CourseController::class, 'addQuestion']);
    Route::post('/questions/{question}/answers', [CourseController::class, 'addAnswer']);



    Route::resource('lessons', LessonController::class)->except(['create', 'edit']);
    Route::resource('questions', QuestionController::class)->except(['create', 'edit']);
    Route::resource('homeworks', HomeworkController::class)->except(['create', 'edit']);
    Route::resource('challenges', ChallengeController::class)->except(['create', 'edit']);
    Route::resource('challenges-completed', ChallengeCompletedController::class)->except(['create', 'edit']);
    Route::resource('challenges-unchecked', ChallengeUncheckedController::class)->except(['create', 'edit']);
});

