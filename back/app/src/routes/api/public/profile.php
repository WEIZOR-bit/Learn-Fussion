<?php

use App\Http\Controllers\ChallengeCompletedController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\ChallengeUncheckedController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseFinishedController;
use App\Http\Controllers\CourseReviewController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\HomeworkUncheckedController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\LessonFinishedController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//Route::middleware(['auth:user', 'verified'])->group(function () {
    Route::group(['prefix' => 'profile'], function () {
        Route::resource('courses', CourseController::class)->except(['create', 'edit', 'show']);
        Route::get('courses/{course}', [CourseController::class, 'show'])->name('courses.show');
        Route::get('courses/{id}/user/{userId}', [CourseController::class, 'showForUser']);
        Route::resource('courses-finished', CourseFinishedController::class)->except(['create', 'edit']);
        Route::resource('lessons-finished', LessonFinishedController::class)->except(['create', 'edit']);
        Route::get('courses-finished/user/{id}', [CourseFinishedController::class, 'getByUserId']);
        Route::get('courses-finished/user/{id}/count', [CourseFinishedController::class, 'countByUserId']);
        Route::resource('courses-reviews', CourseReviewController::class)->except(['create', 'edit']);
        Route::get('courses-reviews/user/{id}', [CourseReviewController::class, 'getByUserId']);
        Route::get('courses-reviews/course/{id}', [CourseReviewController::class, 'getByCourseId']);
        Route::resource('lessons', LessonController::class)->except(['create', 'edit']);
        Route::resource('questions', QuestionController::class)->except(['create', 'edit']);
        Route::resource('homeworks', HomeworkController::class)->except(['create', 'edit']);
        Route::resource('homeworks-unchecked', HomeworkUncheckedController::class)->except(['create', 'edit']);
        Route::resource('challenges', ChallengeController::class)->except(['create', 'edit']);
        Route::resource('challenges-completed', ChallengeCompletedController::class)->except(['create', 'edit']);
        Route::resource('challenges-unchecked', ChallengeUncheckedController::class)->except(['create', 'edit']);

        Route::get('users/rating', [UserController::class, 'rating']);
        Route::get('users/{id}/mastery-level', [UserController::class, 'getMasteryLevel']);
        Route::get('users/{id}/league', [UserController::class, 'getLeague']);
        Route::get('users/{id}/streak', [UserController::class, 'getStreakDays']);
        Route::patch('users/{id}/activity', [UserController::class, 'updateActivity']);
        Route::get('users/{id}/hearts', [UserController::class, 'getHearts']);
        Route::get('users/{id}/stats', [UserController::class, 'getUserStats']);
        Route::post('users/{id}/decrease-hearts', [UserController::class, 'decreaseHearts']);

        Route::resource('users', UserController::class)->except(['create', 'edit']);
    });
//});
