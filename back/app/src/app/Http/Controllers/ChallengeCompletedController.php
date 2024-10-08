<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChallengeCompletedRequest;
use App\Models\ChallengeCompleted;
use App\Services\ChallengeCompletedService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ChallengeCompletedController extends Controller
{

    /**
     * @param ChallengeCompletedService $challengeService
     */
    public function __construct(ChallengeCompletedService $challengeService) {
        $this->challengeComplatedService = $challengeService;
    }

    /**
     * Display a listing of the resource.
     * @return Collection|LengthAwarePaginator
     * @throws AuthorizationException
     */
    public function index(): Collection|LengthAwarePaginator
    {
        $this->authorize('viewAny', ChallengeCompleted::class);
        return $this->challengeComplatedService->all();
    }

    /**
     * Store a newly created resource in storage.
     * @param ChallengeCompletedRequest $request
     * @return JsonResponse
     */
    public function store(ChallengeCompletedRequest $request): JsonResponse
    {
        $createdChallengeCompleted = $this->challengeComplatedService->create($request->validated());
        if (!$createdChallengeCompleted) {
            return response()->json(['error' => 'ChallengeCompleted could not be created'], 500);
        }
        return response()->json(['ChallengeCompleted:' => $createdChallengeCompleted], 200);
    }

    /**
     * Display the specified resource.
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $challengeCompleted = $this->challengeComplatedService->getById($id);
        if (!$challengeCompleted) {
            return response()->json(['error' => 'ChallengeCompleted could not be found'], 500);
        }
        return response()->json(['ChallengeCompleted:' => $challengeCompleted], 200);
    }


    /**
     * Update the specified resource in storage.
     * @param ChallengeCompletedRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(ChallengeCompletedRequest $request, string $id): JsonResponse
    {
        $challengeCompleted = $this->challengeComplatedService->getById($id);
        if (!$challengeCompleted) {
            return response()->json(['error' => 'ChallengeCompleted could not be found'], 500);
        }
        $updatedChallengeCompleted = $this->challengeComplatedService->update($request->validated(), $id);
        if (!$updatedChallengeCompleted) {
            return response()->json(['error' => 'ChallengeCompleted could not be updated'], 500);
        }
        return response()->json(['ChallengeCompleted:' => $updatedChallengeCompleted], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $challengeCompleted = $this->challengeComplatedService->getById($id);
        if (!$challengeCompleted) {
            return response()->json(['error' => 'ChallengeCompleted could not be found'], 500);
        }
        $deletedChallengeCompleted = $this->challengeComplatedService->delete($id);
        if (!$deletedChallengeCompleted) {
            return response()->json(['error' => 'ChallengeCompleted could not be deleted'], 500);
        }
        return response()->json(['message' => "ChallengeCompleted was deleted"], 200);
    }
}
