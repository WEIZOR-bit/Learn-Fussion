<?php

namespace App\Services;

use App\Models\HomeworkLesson;
use App\Repositories\HomeworkLessonRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeworkLessonService
{
    /**
     * Create a new service instance.
     *
     * @param  HomeworkLessonRepository  $homeworkLessonRepository
     * @return void
     */
    public function __construct(private HomeworkLessonRepository $homeworkLessonRepository)
    {
        //
    }

    /**
     * Get a HomeworkLesson by ID.
     *
     * @param int $id
     * @return null|HomeworkLesson
     */
    public function getById(int $id): ?HomeworkLesson
    {
        return $this->homeworkLessonRepository->get(['id' => $id]);
    }

    /**
     * Get all homework lessons, optionally paginated.
     *
     * @param int|null $limit
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function all(?int $limit = null, array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->homeworkLessonRepository->paginate($limit, $columns);
    }

    /**
     * Create a new HomeworkLesson.
     *
     * @param array $data
     * @return HomeworkLesson
     */
    public function create(array $data): HomeworkLesson
    {
        return $this->homeworkLessonRepository->create($data);
    }

    /**
     * Update an existing HomeworkLesson by ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->homeworkLessonRepository->update($this->getById($id), $data);
    }

    /**
     * Delete a HomeworkLesson by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->homeworkLessonRepository->delete($this->getById($id));
    }
}
