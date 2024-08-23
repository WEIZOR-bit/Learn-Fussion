<?php

namespace app\Services;

use App\Models\HomeworkLesson;
use app\Repositories\HomeworkLessonRepository;

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
     * Create a new HomeworkLesson.
     *
     * @param array $data
     * @return HomeworkLesson
     */
    public function createHomeworkLesson(array $data): HomeworkLesson
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
    public function updateHomeworkLesson(int $id, array $data): bool
    {
        return $this->homeworkLessonRepository->update($this->getById($id), $data);
    }

    /**
     * Delete a HomeworkLesson by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteHomeworkLesson(int $id): bool
    {
        return $this->homeworkLessonRepository->delete($this->getById($id));
    }
}
