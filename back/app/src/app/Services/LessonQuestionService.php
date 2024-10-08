<?php

namespace App\Services;

use App\Models\LessonQuestion;
use App\Repositories\LessonQuestionRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class LessonQuestionService
{
    /**
     * Create a new service instance.
     *
     * @param  LessonQuestionRepository  $lessonQuestionRepository
     * @return void
     */
    public function __construct(private LessonQuestionRepository $lessonQuestionRepository)
    {
        //
    }

    /**
     * Get a LessonQuestion by ID.
     *
     * @param int $id
     * @return null|LessonQuestion
     */
    public function getById(int $id): ?LessonQuestion
    {
        return $this->lessonQuestionRepository->get(['id' => $id]);
    }

    /**
     * Get all lesson-question pairs, optionally paginated.
     *
     * @param int|null $limit
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function all(?int $limit = null, array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->lessonQuestionRepository->paginate($limit, $columns);
    }

    /**
     * Create a new LessonQuestion.
     *
     * @param array $data
     * @return LessonQuestion
     */
    public function create(array $data): LessonQuestion
    {
        return $this->lessonQuestionRepository->create($data);
    }

    /**
     * Update an existing LessonQuestion by ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->lessonQuestionRepository->update($this->getById($id), $data);
    }

    /**
     * Delete a LessonQuestion by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->lessonQuestionRepository->delete($this->getById($id));
    }
}
