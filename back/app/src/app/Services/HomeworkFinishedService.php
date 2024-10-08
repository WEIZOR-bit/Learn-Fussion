<?php

namespace App\Services;

use App\Models\HomeworkFinished;
use App\Repositories\HomeworkFinishedRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeworkFinishedService
{
    /**
     * Create a new service instance.
     *
     * @param  HomeworkFinishedRepository  $homeworkFinishedRepository
     * @return void
     */
    public function __construct(private HomeworkFinishedRepository $homeworkFinishedRepository)
    {
        //
    }

    /**
     * Get a HomeworkFinished by ID.
     *
     * @param int $id
     * @return null|HomeworkFinished
     */
    public function getById(int $id): ?HomeworkFinished
    {
        return $this->homeworkFinishedRepository->get(['id' => $id]);
    }

    /**
     * Get all homeworks finished, optionally paginated.
     *
     * @param int|null $limit
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function all(?int $limit = null, array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->homeworkFinishedRepository->paginate($limit, $columns);
    }

    /**
     * Create a new HomeworkFinished.
     *
     * @param array $data
     * @return HomeworkFinished
     */
    public function create(array $data): HomeworkFinished
    {
        return $this->homeworkFinishedRepository->create($data);
    }

    /**
     * Update an existing HomeworkFinished by ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->homeworkFinishedRepository->update($this->getById($id), $data);
    }

    /**
     * Delete a HomeworkFinished by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->homeworkFinishedRepository->delete($this->getById($id));
    }

    /**
     * Get all homeworks finished by a specific user.
     *
     * @param int $userId
     * @return Collection|array
     */
    public function getByUserId(int $userId): Collection|array
    {
        return $this->homeworkFinishedRepository->getAllByUserId($userId);
    }
}
