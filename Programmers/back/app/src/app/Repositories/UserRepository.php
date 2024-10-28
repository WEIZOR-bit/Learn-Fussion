<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  User  $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function search(string $query) {
        return User::where('name', 'LIKE', '%' . $query . '%')
            ->orWhere('email', 'LIKE', '%' . $query . '%')
            ->paginate(10);
    }

    public function rating()
    {
        return User::orderBy('mastery_level', 'desc')
            ->take(10)
            ->get();
    }
}
