<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomeworkUncheckedRequest;
use App\Models\HomeworkUnchecked;
use App\Services\HomeworkUncheckedService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeworkUncheckedController extends Controller
{


    /**
     * @param HomeworkUncheckedService $homeworkService
     */
    public function __construct(HomeworkUncheckedService $homeworkService) {
        $this->homeworkUncheckedService = $homeworkService;
    }

    /**
     * Display a listing of the resource.
     * @return Collection|LengthAwarePaginator
     */
    public function index(): Collection|LengthAwarePaginator
    {
        return $this->homeworkUncheckedService->all();
    }


    /**
     * Store a newly created resource in storage.
     * @param HomeworkUncheckedRequest $request
     * @return JsonResponse
     */
    public function store(HomeworkUncheckedRequest $request): JsonResponse
    {
        $createdHomeworkUnchecked = $this->homeworkUncheckedService->create($request->validated());
        if (!$createdHomeworkUnchecked) {
            return response()->json(['error' => 'HomeworkUnchecked was not created'], 500);
        }
        return response()->json(['homeworkUnchecked' => $createdHomeworkUnchecked], 200);
    }

    /**
     * Display the specified resource.
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $homework = $this->homeworkUncheckedService->getById($id);
        if (!$homework) {
            return response()->json(['error' => 'HomeworkUnchecked not found'], 404);
        }
        return response()->json(['homework' => $homework], 200);
    }


    /**
     * Update the specified resource in storage.
     * @param HomeworkUncheckedRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(HomeworkUncheckedRequest $request, string $id): JsonResponse
    {
        $homework = $this->homeworkUncheckedService->getById($id);
        if (!$homework) {
            return response()->json(['error' => 'HomeworkUnchecked not found'], 404);
        }
        $updatedHomeworkUnchecked = $this->homeworkUncheckedService->update($id, $request->validated());
        if(!$updatedHomeworkUnchecked) {
            return response()->json(['error' => 'HomeworkUnchecked was not updated'], 500);
        }
        $homework = $this->homeworkUncheckedService->getById($id);
        return response()->json(['homework' => $homework], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $homework = $this->homeworkUncheckedService->getById($id);
        if (!$homework) {
            return response()->json(['error' => 'HomeworkUnchecked not found'], 404);
        }
        $deletedHomeworkUnchecked = $this->homeworkUncheckedService->delete($id);
        if (!$deletedHomeworkUnchecked) {
            return response()->json(['error' => 'HomeworkUnchecked was not deleted'], 500);
        }
        return response()->json(['message' => "HomeworkUnchecked was deleted"], 200);
    }
}
