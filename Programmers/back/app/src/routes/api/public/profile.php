<?php

use App\Http\Controllers\ChallengeCompletedController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\ChallengeUncheckedController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseFinishedController;
use App\Http\Controllers\CourseReviewController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



//Route::middleware(['auth:user', 'verified'])->group(function () {
Route::group(['prefix' => 'profile'], function () {
    Route::resource('courses', CourseController::class)->except(['create', 'edit']);
    Route::resource('courses-finished', CourseFinishedController::class)->except(['create', 'edit']);
    Route::get('courses-finished/user/{id}', [CourseFinishedController::class, 'getByUserId']);
    Route::resource('courses-reviews', CourseReviewController::class)->except(['create', 'edit']);
    Route::get('courses-reviews/user/{id}', [CourseReviewController::class, 'getByUserId']);
    Route::get('courses-reviews/course/{id}', [CourseReviewController::class, 'getByCourseId']);
    Route::resource('lessons', LessonController::class)->except(['create', 'edit']);
    Route::resource('questions', QuestionController::class)->except(['create', 'edit']);
    Route::resource('homeworks', HomeworkController::class)->except(['create', 'edit']);
    Route::resource('challenges', ChallengeController::class)->except(['create', 'edit']);
    Route::resource('challenges-completed', ChallengeCompletedController::class)->except(['create', 'edit']);
    Route::resource('challenges-unchecked', ChallengeUncheckedController::class)->except(['create', 'edit']);


    Route::resource('users', UserController::class)->except(['create', 'edit']);

    Route::get('users/{id}/mastery-level', [UserController::class, 'getMasteryLevel']);
    Route::get('users/{id}/league', [UserController::class, 'getLeague']);
    Route::get('users/{id}/streak', [UserController::class, 'getStreakDays']);
    Route::patch('users/{id}/activity', [UserController::class, 'updateActivity']);
});

