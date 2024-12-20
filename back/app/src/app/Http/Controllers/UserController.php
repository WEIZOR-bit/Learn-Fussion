<?php

namespace App\Http\Controllers;

use App\DTOs\UserRatingDTO;
use App\DTOs\UserStatsDTO;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
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
        // Получаем пользователя с завершенными курсами
        $user = $this->userService->getById($id)->load('courses_finished.course');

        if (!$user) {
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

    /**
     * Update user's last activity and reset hearts.
     * @param string $id
     * @return JsonResponse
     */
    public function getUserStats(string $id): JsonResponse
    {
        // Получение пользователя с завершенными курсами
        $user = $this->userService->getById($id);

        // Получение всех данных завершенных курсов пользователя через связь
        $completedCourses = $user->courses_finished()
            ->with('course') // Подгружаем информацию о курсах
            ->get()
            ->map(function ($completedCourse) {
                return [
                    'id' => $completedCourse->course->id,
                    'title' => $completedCourse->course->title,
                    'description' => $completedCourse->course->description,
                    // Добавьте другие поля, которые хотите вернуть
                ];
            })
            ->toArray();

        // Создание DTO с завершенными курсами
        $userStatsDTO = new UserStatsDTO(
            $user->hearts,
            $this->userService->getStreakDays($id),
            $user->mastery_level,
            $completedCourses // Передаем массив объектов завершенных курсов в DTO
        );

        return response()->json($userStatsDTO->toArray());
    }


    /**
     * Update user's last activity and reset hearts.
     * @param string $id
     * @return JsonResponse
     */
    public function decreaseHearts(string $id): JsonResponse
    {
        $user = $this->userService->getById($id);
        if ($user->hearts > 0) {
            $this->userService->update($id, ['hearts' => $user->hearts - 1]);
        }
        $user = $this->userService->getById($id);
        return response()->json($user);
    }

    public function search(Request $request): Collection|LengthAwarePaginator
    {
        $query = $request->input('query');
        Log::debug( $query);
        return $this->userService->search($query);
    }

    public function rating(): JsonResponse
    {
        $topUsers = $this->userService->rating();

        $userRatings = $topUsers->map(function($user) {
            $dto = new UserRatingDTO($user->name, $user->mastery_level);
            return $dto->toArray();
        });

        return response()->json($userRatings);
    }

}
