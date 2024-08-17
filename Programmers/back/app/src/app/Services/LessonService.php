<?php

namespace app\Services;

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
     * Get a lesson by ID.
     *
     * @param int $id
     * @return null|Lesson
     */
    public function getById(int $id): ?Lesson
    {
        return $this->lessonRepository->get(['id' => $id]);
    }

    /**
     * Get all lessons, optionally paginated.
     *
     * @param int|null $limit
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function getAllLessons(?int $limit = null, array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->lessonRepository->paginate($limit, $columns);
    }

    /**
     * Get lessons by the admin who created them.
     *
     * @param int $adminId
     * @param int|null $limit
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function getLessonsByCreator(int $adminId, ?int $limit = null, array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->lessonRepository->paginate($limit, $columns, [
            ['created_by', '=', $adminId]
        ]);
    }

    /**
     * Create a new lesson.
     *
     * @param array $data
     * @return Lesson
     */
    public function createLesson(array $data): Lesson
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
    public function updateLesson(int $id, array $data): bool
    {
        return $this->lessonRepository->update($this->getById($id), $data);
    }

    /**
     * Delete a lesson by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteLesson(int $id): bool
    {
        return $this->lessonRepository->delete($this->getById($id));
    }

    /**
     * Get the most recent lessons.
     *
     * @param int|null $limit
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function getRecentLessons(?int $limit = null, array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->lessonRepository->paginate($limit, $columns);
    }
}
