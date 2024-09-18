<?php

namespace App\Services;

use App\Models\Homework;
use App\Repositories\HomeworkRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeworkService
{
    /**
     * Create a new service instance.
     *
     * @param  HomeworkRepository  $homeworkRepository
     * @return void
     */
    public function __construct(private HomeworkRepository $homeworkRepository)
    {
        //
    }

    /**
     * Get a homework by ID.
     *
     * @param int $id
     * @return null|Homework
     */
    public function getById(int $id): ?Homework
    {
        return $this->homeworkRepository->get(['id' => $id]);
    }

    /**
     * Get all homeworks, optionally paginated.
     *
     * @param int|null $limit
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function all(?int $limit = null, array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->homeworkRepository->paginate($limit, $columns);
    }

    /**
     * Get homeworks by the admin who created them.
     *
     * @param int $adminId
     * @param int|null $limit
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function getByAdminId(int $adminId, ?int $limit = null, array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->homeworkRepository->paginate($limit, $columns, [
            ['created_by', '=', $adminId]
        ]);
    }

    /**
     * Create a new homework.
     *
     * @param array $data
     * @return Homework
     */
    public function create(array $data): Homework
    {
        return $this->homeworkRepository->create($data);
    }

    /**
     * Update an existing homework by ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->homeworkRepository->update($this->getById($id), $data);
    }

    /**
     * Delete a homework by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->homeworkRepository->delete($this->getById($id));
    }
}
