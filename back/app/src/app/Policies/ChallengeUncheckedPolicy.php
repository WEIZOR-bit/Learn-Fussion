<?php

namespace App\Policies;

use App\Models\ChallengeUnchecked;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ChallengeUncheckedPolicy
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
    public function view(User $user, ChallengeUnchecked $challengeUnchecked): bool
    {
        return $user->hasPermissionTo('view articles');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission(['take courses', 'create articles']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ChallengeUnchecked $challengeUnchecked): bool
    {
        return $user->hasAnyPermission(['take courses', 'update articles']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ChallengeUnchecked $challengeUnchecked): bool
    {
        return $user->hasPermissionTo('delete articles');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ChallengeUnchecked $challengeUnchecked): bool
    {
        return $user->hasPermissionTo('delete articles');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ChallengeUnchecked $challengeUnchecked): bool
    {
        return $user->hasRole('Super-Admin');
    }
}
