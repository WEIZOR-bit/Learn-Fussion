<?php

namespace App\Http\Controllers;

use App\Models\Question;
use app\Services\QuestionService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct(QuestionService $questionService) {
           $this->questionService = $questionService;
    }

    public function index(): Collection|LengthAwarePaginator
    {
        $this->authorize('viewAny', Question::class);
        return $this->questionService->all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Question
    {
        $this->authorize('create', Question::class);
        return $this->questionService->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): ?Question
    {
        $this->authorize('create', Question::class);
        return $this->questionService->getById($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): bool
    {
        $this->authorize('update', Question::class);
        return $this->questionService->update($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): bool
    {
        $this->authorize('delete', Question::class);
        return $this->questionService->delete($id);
    }
}
