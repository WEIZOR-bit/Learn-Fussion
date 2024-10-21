<?php

namespace App\Http\Controllers;

use App\DTOs\UserStatsDTO;
use App\Http\Requests\AvatarRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @return Collection|LengthAwarePaginator
     */
    public function index(): Collection|LengthAwarePaginator
    {
        return $this->userService->all();
    }


    /**
     * Store a newly created resource in storage.
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function store(UserRequest $request): JsonResponse
    {
        $createdUser =  $this->userService->storeUser($request->validated());
         if (!$createdUser) {
             return response()->json(['error' => 'User not created'], 500);
         }
         return response()->json(['createdUser' => $createdUser], 200);
    }

    /**
     * Display the specified resource.
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $user =$this->userService->getById($id);
        if(!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        return response()->json(['user' => $user], 200);
    }


    /**
     * Update the specified resource in storage.
     * @param UserRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(UserRequest $request, string $id): JsonResponse
    {
        $user =$this->userService->getById($id);
        if(!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $user = $this->userService->update($id, $request->validated());
        if(!$user) {
            return response()->json(['error' => 'User not created'], 500);
        }
        return response()->json(['updatedUser' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $user =$this->userService->getById($id);
        if(!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $user = $this->userService->delete($id);
        if(!$user) {
            return response()->json(['error' => 'User not deleted'], 500);
        }
        return response()->json(['deletedUser' => $user], 200);

    }

    /**
     * Get the mastery level of the user.
     * @param string $id
     * @return JsonResponse
     */
    public function getMasteryLevel(string $id): JsonResponse
    {

        return response()->json($this->userService->getById($id)->mastery_level);
    }

    /**
     * Get the mastery level of the user.
     * @param string $id
     * @return JsonResponse
     */
    public function getHearts(string $id): JsonResponse
    {

        return response()->json($this->userService->getById($id)->hearts);
    }

    /**
     * Get the league of the user.
     * @param string $id
     * @return JsonResponse
     */
    public function getLeague(string $id): JsonResponse
    {
        return response()->json($this->userService->getUserLeague($id));
    }

    /**
     * Get the number of streak days.
     * @param string $id
     * @return JsonResponse
     */
    public function getStreakDays(string $id): JsonResponse
    {
        return response()->json($this->userService->getStreakDays($id));
    }

    /**
     * Update user's last activity and reset hearts.
     * @param string $id
     * @return JsonResponse
     */
    public function updateActivity(string $id): JsonResponse
    {
        return response()->json($this->userService->updateActivity($id));
    }


    public function updateAvatar(AvatarRequest $request, string $id): JsonResponse
    {
            $request->validated();
        $user =$this->userService->getById($id);

        if ($user->avatar_url) {
            Storage::disk('minio_avatars')->delete($user->avatar_url);
        }

        $path = $request->file('avatar')->store('avatars', 'minio_avatars');

        $user->update([
            'avatar_url' => $path
        ]);

        return response()->json([
            'message' => 'Avatar uploaded successfully',
            'avatar' => $user->avatar_url,
        ]);
    }

    /**
     * Update user's last activity and reset hearts.
     * @param string $id
     * @return JsonResponse
     */
    public function getUserStats(string $id): JsonResponse
    {
        $userStatsDTO = new UserStatsDTO(
            $this->userService->getById($id)->hearts,
            $this->userService->getStreakDays($id),
            $this->userService->getById($id)->mastery_level
        );
        return response()->json($userStatsDTO->toArray());
    }

    public function search(Request $request): Collection|LengthAwarePaginator
    {
        $query = $request->input('query');
        Log::debug( $query);
        return $this->userService->search($query);
    }
}
