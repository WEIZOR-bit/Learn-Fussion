<?php

namespace app\Services;

use app\Models\LessonFinished;
use app\Repositories\LessonFinishedRepository;
use Illuminate\Database\Eloquent\Collection;

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
     * Create a new LessonFinished.
     *
     * @param array $data
     * @return LessonFinished
     */
    public function createLessonFinished(array $data): LessonFinished
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
    public function updateLessonFinished(int $id, array $data): bool
    {
        return $this->lessonFinishedRepository->update($this->getById($id), $data);
    }

    /**
     * Delete a LessonFinished by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteLessonFinished(int $id): bool
    {
        return $this->lessonFinishedRepository->delete($this->getById($id));
    }

    /**
     * Get all lessons finished by a specific user.
     *
     * @param int $userId
     * @return Collection|array
     */
    public function getLessonsFinishedByUser(int $userId): Collection|array
    {
        return $this->lessonFinishedRepository->getAllByUserId($userId);
    }
}
