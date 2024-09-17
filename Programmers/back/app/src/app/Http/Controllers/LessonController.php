<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Services\LessonService;
use Illuminate\Http\Request;

class LessonController extends Controller
{

    public function __construct(LessonService $lessonService)
    {
        $this->lessonService = $lessonService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Lesson::class);
        return $this->lessonService->getAllLessons();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Lesson::class);
        return $this->lessonService->createLesson($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->authorize('view', Lesson::class);
        return $this->lessonService->getLessonById($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('update', Lesson::class);
        return $this->lessonService->updateLesson($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', Lesson::class);
        return $this->lessonService->deleteLesson($id);
    }
}
