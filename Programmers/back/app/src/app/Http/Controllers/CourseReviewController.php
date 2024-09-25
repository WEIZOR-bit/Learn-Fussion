<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseReviewRequest;
use App\Models\CourseReview;
use App\Services\CourseReviewService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class CourseReviewController extends Controller
{

    public function __construct(CourseReviewService $courseReviewService) {
        $this->courseReviewService = $courseReviewService;
    }


    /**
     * Display a listing of the resource.
     *
     * @param void
     * @return Collection|LengthAwarePaginator
     * @throws AuthorizationException
     */
    public function index(): Collection|LengthAwarePaginator
    {
        $this->authorize('viewAny', CourseReview::class);
        return $this->courseReviewService->all();
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param CourseReviewRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(CourseReviewRequest $request): JsonResponse
    {
        Log::debug($request);
        $courseReviewData = $request->validated();
        $createdReview = $this->courseReviewService->create($courseReviewData);
        return response()->json($createdReview, 201);
    }




    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(string $id): JsonResponse
    {
        $courseReview = $this->courseReviewService->getById($id);

    if (!$courseReview) {
        return response()->json([
            'error' => 'Course review not found',
        ], 404);
    }

    $this->authorize('view', $courseReview);

    return response()->json([
        'success' => true,
        'data' => $courseReview,
    ], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param CourseReviewRequest $request
     * @param string $id
     * @return JsonResponse
     * @throws AuthorizationException
     */

    public function update(CourseReviewRequest $request, string $id): JsonResponse
    {
        $this->courseReviewService->update($id, $request->validated());
        $courseReview = $this->courseReviewService->getById($id);
        return response()->json($courseReview, 200);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(string $id): JsonResponse
    {
        $courseReview = $this->courseReviewService->getById($id);
        if (!$courseReview) {
            return response()->json([
                'success' => false,
                'message' => 'Course review not found',
            ], 404);
        }
        $this->authorize('forceDelete', $courseReview);
        if ($this->courseReviewService->delete($id)) {
            return response()->json([
                'success' => true,
                'message' => 'Course review deleted successfully',
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Course review could not be deleted',
        ], 500);
    }



    /**
     * Get a reviews by User ID.
     *
     * @param string $id
     * @return Collection|array
     * @throws AuthorizationException
     */

    public function getByUserId(string $id): Collection|array
    {
        $this->authorize('view articles', CourseReview::class);
        return $this->courseReviewService->getByUserId($id);
    }


    /**
     * Get a reviews by Course ID.
     *
     * @param int $courseId
     * @return Collection|array
     * @throws AuthorizationException
     */
    public function getByCourseId(int $courseId): Collection|array
    {
        $this->authorize('view articles', CourseReview::class);
        return $this->courseReviewService->getByCourseId($courseId);
    }
}
