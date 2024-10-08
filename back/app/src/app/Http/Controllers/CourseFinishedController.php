<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseFinishedRequest;
use App\Models\CourseFinished;
use App\Services\CourseFinishedService;
use http\Env\Response;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CourseFinishedController extends Controller
{

    public function __construct(CourseFinishedService $courseFinishedService) {
        $this->courseFinishedService = $courseFinishedService;
    }

    /**
     * Display a listing of the resource.
     * @return Collection|LengthAwarePaginator
     */
    public function index(): Collection|LengthAwarePaginator
    {
        return $this->courseFinishedService->all();
    }


    /**
     * Store a newly created resource in storage.
     * @param CourseFinishedRequest $request
     * @return JsonResponse
     */
    public function store(CourseFinishedRequest $request): JsonResponse
    {
        $courseFinishedCreated = $this->courseFinishedService->create($request->validated());
        if (!$courseFinishedCreated) {
            return response()->json(['error' => 'Course finished not created'], 500);
        }
        return response()->json(['courseFinishedCreated' => $courseFinishedCreated], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
       $finishedCourse = $this->courseFinishedService->getById($id);
       if (!$finishedCourse) {
           return response()->json(['error' => 'Course not found'], 404);
       }
        return response()->json(['finishedCourse' => $finishedCourse], 200);
    }

    /**
     * Update the specified resource in storage.
     * @param CourseFinishedRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(CourseFinishedRequest $request, string $id): JsonResponse
    {
        $finishedCourse = $this->courseFinishedService->getById($id);
        if (!$finishedCourse) {
            return response()->json(['error' => 'Course not found'], 404);
        }
        $updatedCourse = $this->courseFinishedService->update($id, $request->validated());
        if (!$updatedCourse) {
            return response()->json(['error' => 'Course not updated'], 500);
        }
        $finishedCourse = $this->courseFinishedService->getById($id);
        return response()->json(['finishedCourseUpdated' => $finishedCourse], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $finishedCourse = $this->courseFinishedService->getById($id);
        if (!$finishedCourse) {
            return response()->json(['error' => 'Course not found'], 404);
        }
        $deletedCourse = $this->courseFinishedService->delete($id);
        if (!$deletedCourse) {
            return response()->json(['error' => 'Course not deleted'], 500);
        }
        return response()->json(['message' => "Course Finished wss deleted"], 200);
    }

    /**
     * Get all courses finished by a specific user.
     *
     * @param int $userId
     * @return Collection|array
     */
    public function getByUserId(int $userId): Collection|array
    {
        return $this->courseFinishedService->getByUserId($userId);
    }

    /**
     * Get number of courses finished by a specific user.
     *
     * @param int $userId
     * @return JsonResponse
     */
    public function countByUserId(int $userId): JsonResponse
    {
        return response()->json($this->courseFinishedService->countByUserId($userId));
    }
}
