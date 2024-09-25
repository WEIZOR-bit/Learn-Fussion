<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use App\Services\QuestionService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param QuestionService $questionService
     */

    public function __construct(QuestionService $questionService) {
           $this->questionService = $questionService;
    }

    /**
     * @return Collection|LengthAwarePaginator
     */
    public function index(): Collection|LengthAwarePaginator
    {
        return $this->questionService->all();
    }

    /**
     * Store a newly created resource in storage.
     * @param QuestionRequest $request
     * @return JsonResponse
     */
    public function store(QuestionRequest $request): JsonResponse
    {
        $createdQuestion = $this->questionService->create($request->validated());
        if(!$createdQuestion) {
            return response()->json(['error' => 'Question not created'], 500);
        }
        return response()->json(['createdQuestion' => $createdQuestion]);
    }

    /**
     * Display the specified resource.
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $question = $this->questionService->getById($id);
        if(!$question) {
            return response()->json(['error' => 'Question not found'], 404);
        }
        return response()->json(['question' => $question]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $question = $this->questionService->getById($id);
        if(!$question) {
            return response()->json(['error' => 'Question not found'], 404);
        }
        $updatedQuestion = $this->questionService->update($id, request()->validated());
        if(!$updatedQuestion) {
            return response()->json(['error' => 'Question not updated'], 500);
        }
        $question = $this->questionService->getById($id);
        return response()->json(['updatedQuestion' => $question]);

    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $question = $this->questionService->getById($id);
        if(!$question) {
            return response()->json(['error' => 'Question not found'], 404);
        }
        $deletedQuestion = $this->questionService->delete($id);
        if(!$deletedQuestion) {
            return response()->json(['error' => 'Question not deleted'], 500);
        }
            return response()->json(['message' => 'Question deleted'], 200);
    }
}
