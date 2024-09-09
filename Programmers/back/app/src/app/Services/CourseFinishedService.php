<?php

namespace app\Services;

use app\Models\CourseFinished;
use app\Repositories\CourseFinishedRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CourseFinishedService
{
    /**
     * Create a new service instance.
     *
     * @param  CourseFinishedRepository  $courseFinishedRepository
     * @return void
     */
    public function __construct(private CourseFinishedRepository $courseFinishedRepository)
    {
        //
    }

    /**
     * Get a CourseFinished by ID.
     *
     * @param int $id
     * @return null|CourseFinished
     */
    public function getById(int $id): ?CourseFinished
    {
        return $this->courseFinishedRepository->get(['id' => $id]);
    }

    /**
     * Get all courses finished, optionally paginated.
     *
     * @param int|null $limit
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function all(?int $limit = null, array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->courseFinishedRepository->paginate($limit, $columns);
    }

    /**
     * Create a new CourseFinished.
     *
     * @param array $data
     * @return CourseFinished
     */
    public function create(array $data): CourseFinished
    {
        return $this->courseFinishedRepository->create($data);
    }

    /**
     * Update an existing CourseFinished by ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->courseFinishedRepository->update($this->getById($id), $data);
    }

    /**
     * Delete a CourseFinished by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->courseFinishedRepository->delete($this->getById($id));
    }

    /**
     * Get all courses finished by a specific user.
     *
     * @param int $userId
     * @return Collection|array
     */
    public function getByUserId(int $userId): Collection|array
    {
        return $this->courseFinishedRepository->getAllByUserId($userId);
    }
}
