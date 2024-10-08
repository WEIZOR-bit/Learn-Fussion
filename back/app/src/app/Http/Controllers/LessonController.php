<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Services\LessonService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class LessonController extends Controller
{

    public function __construct(LessonService $lessonService)
    {
        $this->lessonService = $lessonService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Collection|LengthAwarePaginator
    {
        $this->authorize('viewAny', Lesson::class);
        return $this->lessonService->all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Lesson
    {
        $this->authorize('create', Lesson::class);
        return $this->lessonService->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): ?Lesson
    {
        $this->authorize('view', Lesson::class);
        return $this->lessonService->getById($id);
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
