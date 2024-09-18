<?php

namespace App\Http\Controllers;

use App\Models\User;
use app\Services\UserService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): Collection|LengthAwarePaginator
    {
        $this->authorize('viewAny', User::class);
        return $this->userService->all();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): User
    {
        $this->authorize('create', User::class);
        return $this->userService->storeUser($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): User
    {
        $this->authorize('create', User::class);
        return $this->userService->getById($id);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id):bool
    {
        $this->authorize('update', User::class);
        return $this->userService->update($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): bool
    {
        $this->authorize('delete', User::class);
        return $this->userService->delete($id);

    }

    /**
     * Get the mastery level of the user.
     */
    public function getMasteryLevel(string $id):mixed
    {
        $this->authorize('view', User::class);
        return $this->userService->getById($id)->mastery_level;
    }

    /**
     * Get the league of the user.
     */
    public function getLeague(string $id): null|string
    {
        $this->authorize('view', User::class);
        return $this->userService->getUserLeague($id);
    }

    /**
     * Get the number of streak days.
     */
    public function getStreakDays(string $id): int
    {
        $this->authorize('view', User::class);
        return $this->userService->getStreakDays($id);
    }

    /**
     * Update user's last activity and reset hearts.
     */
    public function updateActivity(string $id):bool
    {
        $this->authorize('update', User::class);
        return $this->userService->updateActivity($id);
    }
}
