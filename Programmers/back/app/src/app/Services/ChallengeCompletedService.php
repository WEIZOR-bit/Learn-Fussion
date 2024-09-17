<?php

namespace app\Services;

use app\Models\ChallengeCompleted;
use app\Models\ChallengeUnchecked;
use app\Repositories\ChallengeCompletedRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ChallengeCompletedService
{

    /**
     * Create a new service instance.
     *
     * @param  ChallengeCompletedRepository  $challengeCompletedRepository
     * @param  ChallengeUncheckedService     $challengeUncheckedService
     * @return void
     */
    public function __construct(
        private ChallengeCompletedRepository $challengeCompletedRepository,
        private ChallengeUncheckedService $challengeUncheckedService
    ) {
    }

    /**
     * Get a ChallengeCompleted by ID.
     *
     * @param int $id
     * @return null|ChallengeCompleted
     */
    public function getById(int $id): ?ChallengeCompleted
    {
        return $this->challengeCompletedRepository->get(['id' => $id]);
    }

    /**
     * Get all challenges completed, optionally paginated.
     *
     * @param int|null $limit
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function all(?int $limit = null, array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->challengeCompletedRepository->paginate($limit, $columns);
    }

    /**
     * Create a new ChallengeCompleted.
     *
     * @param array $data
     * @return ChallengeCompleted
     */
    public function create(array $data): ChallengeCompleted
    {
        $challengeId = $data['challenge_id'] ?? null;
        $userId = $data['user_id'] ?? null;

        if (!$challengeId || !$userId) {
            throw new \InvalidArgumentException('challenge_id or user_id is missing.');
        }

        $this->challengeUncheckedService->deleteByUserIdAndChallengeId($userId, $challengeId);

        return $this->challengeCompletedRepository->create($data);
    }

    /**
     * Update an existing ChallengeCompleted by ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->challengeCompletedRepository->update($this->getById($id), $data);
    }

    /**
     * Delete a ChallengeCompleted by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->challengeCompletedRepository->delete($this->getById($id));
    }
}
