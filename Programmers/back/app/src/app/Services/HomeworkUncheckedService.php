<?php

namespace App\Services;

use App\Models\HomeworkUnchecked;
use App\Repositories\HomeworkUncheckedRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeworkUncheckedService
{
    /**
     * Create a new service instance.
     *
     * @param  HomeworkUncheckedRepository  $homeworkUncheckedRepository
     * @return void
     */
    public function __construct(private HomeworkUncheckedRepository $homeworkUncheckedRepository)
    {
        //
    }

    /**
     * Get a HomeworkUnchecked by ID.
     *
     * @param int $id
     * @return null|HomeworkUnchecked
     */
    public function getById(int $id): ?HomeworkUnchecked
    {
        return $this->homeworkUncheckedRepository->get(['id' => $id]);
    }

    /**
     * Get all homeworks completed, optionally paginated.
     *
     * @param int|null $limit
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function all(?int $limit = null, array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->homeworkUncheckedRepository->paginate($limit, $columns);
    }

    /**
     * Create a new HomeworkUnchecked.
     *
     * @param array $data
     * @return HomeworkUnchecked
     */
    public function create(array $data): HomeworkUnchecked
    {
        return $this->homeworkUncheckedRepository->create($data);
    }

    /**
     * Update an existing HomeworkUnchecked by ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->homeworkUncheckedRepository->update($this->getById($id), $data);
    }

    /**
     * Delete a HomeworkUnchecked by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->homeworkUncheckedRepository->delete($this->getById($id));
    }

    /**
     * Delete an entry from homeworks_unchecked by user_id and challenge_id.
     *
     * @param int $userId
     * @param int $homeworkId
     * @return bool
     */
    public function deleteByUserIdAndHomeworkId(int $userId, int $homeworkId): bool {
        return $this->homeworkUncheckedRepository->deleteByUserIdAndHomeworkId($userId,$homeworkId);
    }
}
