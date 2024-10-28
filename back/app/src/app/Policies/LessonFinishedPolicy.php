<?php

namespace App\Policies;

use App\Models\LessonFinished;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LessonFinishedPolicy
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
    public function view(User $user, LessonFinished $lessonFinished): bool
    {
        return $user->hasPermissionTo('view articles');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('take courses');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, LessonFinished $lessonFinished): bool
    {
        return $user->hasPermissionTo('take courses');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LessonFinished $lessonFinished): bool
    {
        return $user->hasRole('Super-Admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, LessonFinished $lessonFinished): bool
    {
        return $user->hasRole('Super-Admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, LessonFinished $lessonFinished): bool
    {
        return $user->hasRole('Super-Admin');
    }
}
