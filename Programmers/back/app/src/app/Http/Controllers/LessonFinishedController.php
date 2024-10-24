<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonFinishedRequest;
use App\Services\LessonFinishedService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class LessonFinishedController extends Controller
{

    public function __construct(private LessonFinishedService $lessonFinishedService) {
        //
    }

    /**
     * Display a listing of the resource.
     * @return Collection|LengthAwarePaginator
     */
    public function index(): Collection|LengthAwarePaginator
    {
        return $this->lessonFinishedService->all();
    }


    /**
     * Store a newly created resource in storage.
     * @param LessonFinishedRequest $request
     * @return JsonResponse
     */
    public function store(LessonFinishedRequest $request): JsonResponse
    {
        $lessonFinishedCreated = $this->lessonFinishedService->create($request->validated());
        if (!$lessonFinishedCreated) {
            return response()->json(['error' => 'Lesson finished not created'], 500);
        }
        return response()->json(['lessonFinishedCreated' => $lessonFinishedCreated], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $finishedLesson = $this->lessonFinishedService->getById($id);
        if (!$finishedLesson) {
            return response()->json(['error' => 'Lesson finished not found'], 404);
        }
        return response()->json(['finishedLesson' => $finishedLesson], 200);
    }

    /**
     * Update the specified resource in storage.
     * @param LessonFinishedRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(LessonFinishedRequest $request, string $id): JsonResponse
    {
        $finishedLesson = $this->lessonFinishedService->getById($id);
        if (!$finishedLesson) {
            return response()->json(['error' => 'Lesson not found'], 404);
        }
        $updatedLesson = $this->lessonFinishedService->update($id, $request->validated());
        if (!$updatedLesson) {
            return response()->json(['error' => 'Lesson not updated'], 500);
        }
        $finishedLesson = $this->lessonFinishedService->getById($id);
        return response()->json(['finishedCourseUpdated' => $finishedLesson], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $finishedLesson = $this->lessonFinishedService->getById($id);
        if (!$finishedLesson) {
            return response()->json(['error' => 'Lesson not found'], 404);
        }
        $deletedLesson = $this->lessonFinishedService->delete($id);
        if (!$deletedLesson) {
            return response()->json(['error' => 'Lesson not deleted'], 500);
        }
        return response()->json(['message' => "Lesson Finished wss deleted"], 200);
    }
}
