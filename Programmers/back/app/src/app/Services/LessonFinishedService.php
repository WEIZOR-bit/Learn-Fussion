<?php

namespace App\Services;

use App\Models\LessonFinished;
use App\Repositories\LessonFinishedRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class LessonFinishedService
{
    /**
     * Create a new service instance.
     *
     * @param  LessonFinishedRepository  $lessonFinishedRepository
     * @return void
     */
    public function __construct(private LessonFinishedRepository $lessonFinishedRepository)
    {
        //
    }

    /**
     * Get a LessonFinished by ID.
     *
     * @param int $id
     * @return null|LessonFinished
     */
    public function getById(int $id): ?LessonFinished
    {
        return $this->lessonFinishedRepository->get(['id' => $id]);
    }

    /**
     * Get all lessons finished, optionally paginated.
     *
     * @param int|null $limit
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function all(?int $limit = null, array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->lessonFinishedRepository->paginate($limit, $columns);
    }

    /**
     * Create a new LessonFinished.
     *
     * @param array $data
     * @return LessonFinished
     */
    public function create(array $data): LessonFinished
    {
        return $this->lessonFinishedRepository->create($data);
    }

    /**
     * Update an existing LessonFinished by ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->lessonFinishedRepository->update($this->getById($id), $data);
    }

    /**
     * Delete a LessonFinished by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->lessonFinishedRepository->delete($this->getById($id));
    }

    /**
     * Get all lessons finished by a specific user.
     *
     * @param int $userId
     * @return Collection|array
     */
    public function getByUserId(int $userId): Collection|array
    {
        return $this->lessonFinishedRepository->getAllByUserId($userId);
    }
}
