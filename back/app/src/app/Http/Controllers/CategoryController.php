<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function __construct(CategoryService $categoryService) {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->categoryService->all());

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        $createdChallenge = $this->categoryService->create($request->validated());
        if(!$createdChallenge) {
            return response()->json(['error' => 'Challenge was not created'], 500);
        }
        return response()->json(['challenge' => $createdChallenge]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $category = $this->categoryService->getById($id);
        if(!$category) {
            return response()->json(['error' => 'Category does not exist'], 500);
        }
        return response()->json(['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     * @param CategoryRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(CategoryRequest $request, string $id): JsonResponse
    {
        $category = $this->categoryService->getById($id);
        if(!$category) {
            return response()->json(['error' => 'Category does not exist'], 500);
        }
        $updatedCategory = $this->categoryService->update($id, $request->validated());
        if(!$updatedCategory) {
            return response()->json(['error' => 'Category was not updated'], 500);
        }
        $category = $this->categoryService->getById($id);
        return  response()->json(['category' => $category], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $category = $this->categoryService->getById($id);
        if(!$category) {
            return response()->json(['error' => 'Challenge does not exist'], 500);
        }
        $deletedCategory = $this->categoryService->delete($id);
        if(!$deletedCategory) {
            return response()->json(['error' => 'Challenge was not deleted'], 500);
        }
        return response()->json(['message' => "Challenge was deleted"]);
    }
}
