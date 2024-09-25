<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChallengeRequest;
use App\Models\Challenge;
use App\Services\ChallengeService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ChallengeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param ChallengeService $challengeService
     */

    public function __construct(ChallengeService $challengeService) {
        $this->challengeService = $challengeService;
    }

    /**
     * @return Collection|LengthAwarePaginator
     */
    public function index(): Collection|LengthAwarePaginator
    {
        return $this->challengeService->all();
    }


    /**
     * Store a newly created resource in storage.
     * @param ChallengeRequest $request
     * @return JsonResponse
     */
    public function store(ChallengeRequest $request): JsonResponse
    {
        $createdChallenge = $this->challengeService->create($request->validated());
        if(!$createdChallenge) {
            return response()->json(['error' => 'Challenge was not created'], 500);
        }
        return response()->json(['challenge' => $createdChallenge], 200);
    }

    /**
     * Display the specified resource.
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
       $challenge = $this->challengeService->getById($id);
       if(!$challenge) {
           return response()->json(['error' => 'Challenge does not exist'], 500);
       }
        return response()->json(['challenge' => $challenge], 200);
    }


    /**
     * Update the specified resource in storage.
     * @param ChallengeRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(ChallengeRequest $request, string $id): JsonResponse
    {
        $challenge = $this->challengeService->getById($id);
        if(!$challenge) {
            return response()->json(['error' => 'Challenge does not exist'], 500);
        }
        $updatedChallenge = $this->challengeService->update($id, $request->validated());
        if(!$updatedChallenge) {
            return response()->json(['error' => 'Challenge was not updated'], 500);
        }
        $challenge = $this->challengeService->getById($id);
        return  response()->json(['challenge' => $challenge], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $challenge = $this->challengeService->getById($id);
        if(!$challenge) {
            return response()->json(['error' => 'Challenge does not exist'], 500);
        }
        $deletedChallenge = $this->challengeService->delete($id);
        if(!$deletedChallenge) {
            return response()->json(['error' => 'Challenge was not deleted'], 500);
        }
        return response()->json(['message' => "Challenge was deleted"], 200);
    }
}
