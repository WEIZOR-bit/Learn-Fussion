<?php

namespace App\Services;

use App\Models\Challenge;
use App\Repositories\ChallengeRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ChallengeService
{
    /**
     * Create a new service instance.
     *
     * @param  ChallengeRepository  $challengeRepository
     * @return void
     */
    public function __construct(private ChallengeRepository $challengeRepository)
    {
        //
    }

    /**
     * Get a Challenge by ID.
     *
     * @param int $id
     * @return null|Challenge
     */
    public function getById(int $id): ?Challenge
    {
        return $this->challengeRepository->get(['id' => $id]);
    }

    /**
     * Get all challenges, optionally paginated.
     *
     * @param int|null $limit
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function all(?int $limit = null, array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->challengeRepository->paginate($limit, $columns);
    }

    /**
     * Create a new Challenge.
     *
     * @param array $data
     * @return Challenge
     */
    public function create(array $data): Challenge
    {
        return $this->challengeRepository->create($data);
    }

    /**
     * Update an existing Challenge by ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->challengeRepository->update($this->getById($id), $data);
    }

    /**
     * Delete a Challenge by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->challengeRepository->delete($this->getById($id));
    }
}
