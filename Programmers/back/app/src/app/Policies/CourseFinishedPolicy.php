<?php

namespace App\Policies;

use App\Models\CourseFinished;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CourseFinishedPolicy
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
    public function view(User $user, CourseFinished $courseFinished): bool
    {
        return $user->hasPermissionTo('view articles');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->hasPermissionTo('take courses') || $user->hasRole('Super-Admin')) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CourseFinished $courseFinished): bool
    {
        return $user->hasRole('Super-Admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CourseFinished $courseFinished): bool
    {
        return $user->hasRole('Super-Admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CourseFinished $courseFinished): bool
    {
        return $user->hasRole('Super-Admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CourseFinished $courseFinished): bool
    {
        return $user->hasRole('Super-Admin');
    }
}
