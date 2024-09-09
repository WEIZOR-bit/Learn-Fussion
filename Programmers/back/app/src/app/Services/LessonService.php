<?php

namespace App\Services;

use App\Models\Lesson;
use App\Repositories\LessonRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class LessonService
{
    /**
     * Create a new service instance.
     *
     * @param  LessonRepository  $lessonRepository
     * @return void
     */
    public function __construct(private LessonRepository $lessonRepository)
    {
        //
    }

    /**
     * Get all lessons, optionally paginated.
     *
     * @param int|null $limit
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function all(?int $limit = null, array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->lessonRepository->paginate($limit, $columns);
    }

    /**
     * Create a new lesson.
     *
     * @param array $data
     * @return Lesson
     */
    public function create(array $data)
    {
        return $this->lessonRepository->create($data);
    }

    /**
     * Update an existing lesson by ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->lessonRepository->update($this->getById($id), $data);
    }

    /**
     * Delete a lesson by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->lessonRepository->delete($this->getById($id));
    }

    /**
     * Get a lesson by ID.
     *
     * @param int $id
     * @return null|Lesson
     */
    public function getById(int $id): ?Lesson
    {
        return $this->lessonRepository->findOrFail($id);
    }
}
