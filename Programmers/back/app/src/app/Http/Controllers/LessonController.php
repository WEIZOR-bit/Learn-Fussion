<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Services\LessonService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class LessonController extends Controller
{

    public function __construct(LessonService $lessonService)
    {
        $this->lessonService = $lessonService;
    }

    public function index(): Collection|LengthAwarePaginator
    {
        $this->authorize('viewAny', Lesson::class);
        return $this->lessonService->all();
    }

    public function store(Request $request): Lesson
    {
        $this->authorize('create', Lesson::class);
        return $this->lessonService->create($request->all());
    }

    public function show(string $id, Request $request): \Illuminate\Http\JsonResponse
    {
        $this->authorize('view', Lesson::class);
        $lesson = Lesson::with(['course', 'lesson_questions.questions_answers'])->findOrFail($id);
        return response()->json($lesson);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): bool
    {
        $this->authorize('update', Lesson::class);
        return $this->lessonService->update($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): bool
    {
        $this->authorize('delete', Lesson::class);
        return $this->lessonService->delete($id);
    }
}
