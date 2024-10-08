<?php

namespace App\Http\Controllers;

use App\DTOs\CourseDetailedDTO;
use App\DTOs\CourseShortDTO;
use App\DTOs\LessonShortDTO;
use App\Http\Requests\CourseRequest;
use App\Models\Admin;
use App\Models\Course;
use App\Models\User;
use App\Services\CourseService;
use Illuminate\Http\JsonResponse;

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
        $courses = Course::query()->paginate(10);

        $coursesDTO = $courses->getCollection()->map(function ($course) {
            return new CourseShortDTO(
                $course->id,
                $course->name,
                $course->category,
                Admin::query()->find($course->created_by)->name,
            );
        });

        return response()->json([
            'data' => $coursesDTO,
            'pagination' => [
                'total' => $courses->total(),
                'per_page' => $courses->perPage(),
                'current_page' => $courses->currentPage(),
                'last_page' => $courses->lastPage(),
                'from' => $courses->firstItem(),
                'to' => $courses->lastItem(),
            ],
        ]);
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
        $course = $this->courseService->getById($id);
        $lessons = $course->lessons();
        if(!$course) {
            return response()->json([
                'message' => 'Course not found',
                404
            ]);
        }
        return response()->json($course);
    }

    /**
     * Display the course for a user.
     * @param string $id
     * @param string $userId
     * @return JsonResponse
     */
    public function showForUser(string $id, string $userId): JsonResponse
    {
        // Fetch course by ID
        $course = $this->courseService->getById($id);
        if (!$course) {
            return response()->json([
                'message' => 'Course not found',
            ], 404);
        }

        // Fetch the user
        $user = User::query()->where('id', $userId)->first();
        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        // Get the lessons for the course
        $lessons = $course->lessons()->get();

        // Get lessons finished by the user
        $lessonsFinishedByUser = $user->lessons_finished()->pluck('lesson_id')->toArray(); // Fetch finished lesson IDs

        // Map each lesson to a LessonShortDTO, marking it as finished if the user has completed it
        $lessonsDTOs = $lessons->map(function ($lesson) use ($lessonsFinishedByUser) {
            return new LessonShortDTO(
                $lesson->id,
                $lesson->name,
                in_array($lesson->id, $lessonsFinishedByUser) // Check if the user has finished the lesson
            );
        })->toArray(); // Convert the collection to an array

        // Create the CourseDetailedDTO
        $courseDTO = new CourseDetailedDTO(
            $course->id,
            $course->name,
            $course->description,
            $course->category,
            $course->created_by, // Assuming 'created_by' is the author
            $lessonsDTOs // Pass the lessons mapped to DTOs
        );

        // Return the course data as JSON
        return response()->json($courseDTO->toArray());
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
