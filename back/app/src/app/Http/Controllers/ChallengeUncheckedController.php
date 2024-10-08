<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChallengeUncheckedRequest;
use App\Models\ChallengeUnchecked;
use App\Services\ChallengeUncheckedService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ChallengeUncheckedController extends Controller
{


    /**
     * @param ChallengeUncheckedService $challengeService
     */
    public function __construct(ChallengeUncheckedService $challengeService) {
        $this->challengeUncheckedService = $challengeService;
    }

    /**
     * Display a listing of the resource.
     * @return Collection|LengthAwarePaginator
     */
    public function index(): Collection|LengthAwarePaginator
    {
        return $this->challengeUncheckedService->all();
    }


    /**
     * Store a newly created resource in storage.
     * @param ChallengeUncheckedRequest $request
     * @return JsonResponse
     */
    public function store(ChallengeUncheckedRequest $request): JsonResponse
    {
       $createdChallengeUnchecked = $this->challengeUncheckedService->create($request->validated());
       if (!$createdChallengeUnchecked) {
           return response()->json(['error' => 'ChallengeUnchecked was not created'], 500);
       }
        return response()->json(['challengeUnchecked' => $createdChallengeUnchecked], 200);
    }

    /**
     * Display the specified resource.
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $challenge = $this->challengeUncheckedService->getById($id);
        if (!$challenge) {
            return response()->json(['error' => 'ChallengeUnchecked not found'], 404);
        }
        return response()->json(['challenge' => $challenge], 200);
    }


    /**
     * Update the specified resource in storage.
     * @param ChallengeUncheckedRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(ChallengeUncheckedRequest $request, string $id): JsonResponse
    {
        $challenge = $this->challengeUncheckedService->getById($id);
        if (!$challenge) {
            return response()->json(['error' => 'ChallengeUnchecked not found'], 404);
        }
        $updatedChallengeUnchecked = $this->challengeUncheckedService->update($id, $request->validated());
        if(!$updatedChallengeUnchecked) {
            return response()->json(['error' => 'ChallengeUnchecked was not updated'], 500);
        }
        $challenge = $this->challengeUncheckedService->getById($id);
        return response()->json(['challenge' => $challenge], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $challenge = $this->challengeUncheckedService->getById($id);
        if (!$challenge) {
            return response()->json(['error' => 'ChallengeUnchecked not found'], 404);
        }
        $deletedChallengeUnchecked = $this->challengeUncheckedService->delete($id);
        if (!$deletedChallengeUnchecked) {
            return response()->json(['error' => 'ChallengeUnchecked was not deleted'], 500);
        }
        return response()->json(['message' => "ChallengeUnchecked was deleted"], 200);
    }
}
