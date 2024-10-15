<?php

namespace App\Http\Controllers;

use App\DTOs\CourseDetailedDTO;
use App\DTOs\CourseShortDTO;
use App\DTOs\LessonShortDTO;
use App\Http\Requests\CourseRequest;
use App\Models\Admin;
use App\Models\Answer;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\User;
use App\Services\CourseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $courses = Course::query()->paginate(10);

        $coursesDTO = $courses->getCollection()->map(function ($course) {
            return new CourseShortDTO(
                $course->id,
                $course->name,
                $course->category,
                Admin::query()->find($course->created_by)->name,
                $course->published,
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
    public function store(CourseRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $course = $this->courseService->createCourse($validatedData);

        return response()->json($course, 201);
    }


    /**
     * Add lesson to course
     * @param CourseRequest $request
     * @param Course $course
     * @return JsonResponse
     */
    public function addLessons(Request $request, Course $course): JsonResponse
    {
        DB::beginTransaction();
        try {
            foreach ($request['lessons'] as $lessonData) {
                Log::debug('Lessons data:', $lessonData);
                $lesson = Lesson::create([
                    'order' => $lessonData['order'],
                    'name' => $lessonData['name'],
                    'description' => $lessonData['description'] ?? null,
                    'tutorial_link' => $lessonData['tutorial_link'] ?? null,
                    'average_rating' => $lessonData['average_rating'] ?? null,
                    'review_count' => $lessonData['review_count'] ?? null,
                    'question_count' => $lessonData['question_count'] ?? null,
                    'created_by' => $lessonData['created_by'],
                    'updated_by' => $lessonData['updated_by'],
                    'course_id' => $course->id,
                ]);

                foreach ($lessonData['questions'] as $questionData) {
//                    Log::debug('second foreach',$request['questions']);
                    $question = Question::create([
                        'name' => $questionData['name'],
                        'matter' => $questionData['matter'],
                        'lesson_id' => $lesson->id,
                    ]);

                    foreach ($questionData['answers'] as $answerData) {
//                        Log::debug($request['answers']);
                        $answer = Answer::create([
                            'text' => $answerData['text'],
                            'correct' => $answerData['correct'],
                        ]);

                        $question->questions_answers()->attach($answer['id']);
                    }

                }
            }


            DB::commit();
            return response()->json(['message' => 'Course created successfully'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create course', 'details' => $e->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $course = $this->courseService->getById($id);
        if(!$course) {
            return response()->json([
                'message' => 'Course not found',
                404
            ]);
        }
        $course->load('lessons.lesson_questions.questions_answers', 'creator');
        return response()->json($course);
    }

    public function publish(int $id): JsonResponse
    {
        Log::debug($id);
        if(!$course = $this->courseService->getById($id)) {
            return response()->json(['message' => 'Course not found'], 404);
        }
        $courseUpdated = $this->courseService->updateCourse($id, ['published' => true]);
        $course = $this->courseService->getById($id);



        if (!$courseUpdated) {
            return response()->json(['message' => 'Course not updated'], 500);
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
