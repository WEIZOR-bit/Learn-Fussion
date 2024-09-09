<?php

namespace app\Services;

use app\Models\ChallengeUnchecked;
use app\Repositories\ChallengeUncheckedRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ChallengeUncheckedService
{
    /**
     * Create a new service instance.
     *
     * @param  ChallengeUncheckedRepository  $challengeUncheckedRepository
     * @return void
     */
    public function __construct(private ChallengeUncheckedRepository $challengeUncheckedRepository)
    {
        //
    }

    /**
     * Get a ChallengeUnchecked by ID.
     *
     * @param int $id
     * @return null|ChallengeUnchecked
     */
    public function getById(int $id): ?ChallengeUnchecked
    {
        return $this->challengeUncheckedRepository->get(['id' => $id]);
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
        return $this->challengeUncheckedRepository->paginate($limit, $columns);
    }

    /**
     * Create a new ChallengeUnchecked.
     *
     * @param array $data
     * @return ChallengeUnchecked
     */
    public function create(array $data): ChallengeUnchecked
    {
        return $this->challengeUncheckedRepository->create($data);
    }

    /**
     * Update an existing ChallengeUnchecked by ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->challengeUncheckedRepository->update($this->getById($id), $data);
    }

    /**
     * Delete a ChallengeUnchecked by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->challengeUncheckedRepository->delete($this->getById($id));
    }
}
