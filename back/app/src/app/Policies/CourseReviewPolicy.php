<?php

namespace App\Policies;

use App\Models\CourseReview;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

class CourseReviewPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view articles');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CourseReview $courseReview): bool
    {
        return $user->hasPermissionTo('view articles');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user,  CourseReview $courseReview): bool
    {
        $finishedCourses = $user->courses_finished;
        $hasFinished = $finishedCourses->contains(function ($courseFinished) use ($courseReview) {
            return $courseFinished->course_id == $courseReview->course_id;
        });
        return $hasFinished;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CourseReview $courseReview): bool
    {
        return $user->id == $courseReview->user_id;

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CourseReview $courseReview): bool
    {
        if($user->id == $courseReview->user_id || $user->hasRole('Super-Admin')) {
            Log::debug('true');
            return true;
        } else {
            Log::debug('false');
            return false;
        }

    }
}
