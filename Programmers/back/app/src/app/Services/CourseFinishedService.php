<?php

namespace app\Services;

use app\Models\CourseFinished;
use app\Repositories\CourseFinishedRepository;
use Illuminate\Database\Eloquent\Collection;

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
     * Create a new CourseFinished.
     *
     * @param array $data
     * @return CourseFinished
     */
    public function createCourseFinished(array $data): CourseFinished
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
    public function updateCourseFinished(int $id, array $data): bool
    {
        return $this->courseFinishedRepository->update($this->getById($id), $data);
    }

    /**
     * Delete a CourseFinished by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteCourseFinished(int $id): bool
    {
        return $this->courseFinishedRepository->delete($this->getById($id));
    }

    /**
     * Get all courses finished by a specific user.
     *
     * @param int $userId
     * @return Collection|array
     */
    public function getCoursesFinishedByUser(int $userId): Collection|array
    {
        return $this->courseFinishedRepository->getAllByUserId($userId);
    }
}
