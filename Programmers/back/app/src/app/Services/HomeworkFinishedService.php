<?php

namespace app\Services;

use app\Models\HomeworkFinished;
use app\Repositories\HomeworkFinishedRepository;
use Illuminate\Database\Eloquent\Collection;

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
     * Create a new HomeworkFinished.
     *
     * @param array $data
     * @return HomeworkFinished
     */
    public function createHomeworkFinished(array $data): HomeworkFinished
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
    public function updateHomeworkFinished(int $id, array $data): bool
    {
        return $this->homeworkFinishedRepository->update($this->getById($id), $data);
    }

    /**
     * Delete a HomeworkFinished by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteHomeworkFinished(int $id): bool
    {
        return $this->homeworkFinishedRepository->delete($this->getById($id));
    }

    /**
     * Get all homeworks finished by a specific user.
     *
     * @param int $userId
     * @return Collection|array
     */
    public function getHomeworksFinishedByUser(int $userId): Collection|array
    {
        return $this->homeworkFinishedRepository->getAllByUserId($userId);
    }
}
