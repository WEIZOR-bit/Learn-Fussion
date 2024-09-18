<?php

namespace App\Http\Controllers;

use App\Models\Homework;
use app\Services\HomeworkService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeworkController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct(HomeworkService $homeworkService) {
        $this->homeworkService = $homeworkService;
    }
    public function index(): Collection|LengthAwarePaginator
    {
        $this->authorize('viewAny', Homework::class);
        return $this->homeworkService->all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Homework
    {
        $this->authorize('create', Homework::class);
        return $this->homeworkService->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): ?Homework
    {
        $this->authorize('create', Homework::class);
        return $this->homeworkService->getById($id);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): bool
    {
        $this->authorize('update', Homework::class);
        return $this->homeworkService->update($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): bool
    {
        $this->authorize('delete', Homework::class);
        return $this->homeworkService->delete($id);
    }
}
