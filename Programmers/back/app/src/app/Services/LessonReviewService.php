<?php

namespace app\Services;

use app\Models\LessonReview;
use app\Repositories\LessonReviewRepository;
use Illuminate\Database\Eloquent\Collection;

class LessonReviewService
{
    /**
     * Create a new service instance.
     *
     * @param  LessonReviewRepository  $lessonReviewRepository
     * @return void
     */
    public function __construct(private LessonReviewRepository $lessonReviewRepository)
    {
        //
    }

    /**
     * Get a LessonReview by ID.
     *
     * @param int $id
     * @return null|LessonReview
     */
    public function getById(int $id): ?LessonReview
    {
        return $this->lessonReviewRepository->get(['id' => $id]);
    }

    /**
     * Create a new LessonReview.
     *
     * @param array $data
     * @return LessonReview
     */
    public function createLessonReview(array $data): LessonReview
    {
        return $this->lessonReviewRepository->create($data);
    }

    /**
     * Update an existing LessonReview by ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateLessonReview(int $id, array $data): bool
    {
        return $this->lessonReviewRepository->update($this->getById($id), $data);
    }

    /**
     * Delete a LessonReview by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteLessonReview(int $id): bool
    {
        return $this->lessonReviewRepository->delete($this->getById($id));
    }

    /**
     * Get all lessons finished by a specific user.
     *
     * @param int $userId
     * @return Collection|array
     */
    public function getAllLessonReviewsByUser(int $userId): Collection|array
    {
        return $this->lessonReviewRepository->getAllByUserId($userId);
    }

    /**
     * Get all reviews for a specific lesson
     *
     * @param int $courseId
     * @return Collection|array
     */
    public function getAllReviewsForCourse(int $courseId): Collection|array
    {
        return $this->lessonReviewRepository->getAllByLessonId($courseId);
    }
}

