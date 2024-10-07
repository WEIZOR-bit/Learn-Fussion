<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Services\CourseService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param void
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $response = response()->json($this->courseService->getAllCourses());
        return response()->json($response, 200);
    }


    /**
     * Store a newly created resource in storage.
     * @param CourseRequest $request
     * @return JsonResponse
     */
    public function store(CourseRequest $request)
    {
        $validatedData = $request->validated();

        $course = $this->courseService->createCourse($validatedData);

        return response()->json($course, 201);
    }

    /**
     * Display the specified resource.
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $courses = $this->courseService->getById($id);
        if(!$courses) {
            return response()->json([
                'message' => 'Course not found',
                404
            ]);
        }
        return response()->json($courses, 200);
    }


    /**
     * Update the specified resource in storage.
     * @param CourseRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(CourseRequest $request, string $id)
    {
        $course = $this->courseService->getById($id);
        if(!$course) {
            return response()->json([
                'message' => 'Course not found',
                404
            ]);
        }
        $updatedCourse = $this->courseService->updateCourse($id, $request->validated());
        if(!$updatedCourse) {
            return response()->json(['message' => 'Course not updated'], 500);
        }
        $course = $this->courseService->getById($id);
           return response()->json($course, 200);
    }



    /**
     * Delete the specified resource in storage.
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $course = $this->courseService->getById($id);
        if(!$course) {
            return response()->json(["message" => "Course not found"], 404);
        }
        $deletedCourse = $this->courseService->deleteCourse($id);
        if(!$deletedCourse) {
            return response()->json(['message' => 'Course not deleted'], 500);
        }
        return response()->json(['message' => 'Course deleted'], 204);

    }

}
