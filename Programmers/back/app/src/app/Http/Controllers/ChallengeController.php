<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use app\Services\ChallengeService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ChallengeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct(ChallengeService $challengeService) {
        $this->challengeService = $challengeService;
    }

    public function index(): Collection|LengthAwarePaginator
    {
        $this->authorize('viewAny', Challenge::class);
        return $this->challengeService->all();
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Challenge
    {
        $this->authorize('create', Challenge::class);
        return $this->challengeService->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Challenge
    {
        $this->authorize('create', Challenge::class);
        return $this->challengeService->getById($id);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): bool
    {
        $this->authorize('update', Challenge::class);
        return $this->challengeService->update($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): bool
    {
        $this->authorize('delete', Challenge::class);
        return $this->challengeService->delete($id);
    }
}
