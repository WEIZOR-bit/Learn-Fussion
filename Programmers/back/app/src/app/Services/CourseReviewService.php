<?php

namespace App\Services;

use App\Models\CourseReview;
use App\Repositories\CourseReviewRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class CourseReviewService
{
    /**
     * Create a new service instance.
     *
     * @param  CourseReviewRepository  $courseReviewRepository
     * @return void
     */
    public function __construct(private CourseReviewRepository $courseReviewRepository)
    {
        //
    }

    /**
     * Get a CourseReview by ID.
     *
     * @param int $id
     * @return null|CourseReview
     * @throws ModelNotFoundException If the course review is not found.
     */
    public function getById(int $id): ?CourseReview
    {
        $courseReview = $this->courseReviewRepository->get(['id' => $id]);
        if (!$courseReview) {
            throw new ModelNotFoundException("Course review not found.");
        }

        return $courseReview;
    }


    /**
     * Get all course reviews, optionally paginated.
     *
     * @param int|null $limit
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function all(?int $limit = null, array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->courseReviewRepository->paginate($limit, $columns);
    }

    /**
     * Create a new CourseReview.
     *
     * @param array $data
     * @return CourseReview
     */
    public function create(array $data): CourseReview
    {
        return $this->courseReviewRepository->create($data);
    }

    /**
     * Update an existing CourseReview by ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->courseReviewRepository->update($this->getById($id), $data);
    }

    /**
     * Delete a CourseReview by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->courseReviewRepository->delete($this->getById($id));
    }

    /**
     * Get all courses reviews written by a specific user.
     *
     * @param int $userId
     * @return Collection|array
     */
    public function getByUserId(int $userId): Collection|array
    {
        return $this->courseReviewRepository->getAllByUserId($userId);
    }

    /**
     * Get all reviews for a specific course
     *
     * @param int $courseId
     * @return Collection|array
     */
    public function getByCourseId(int $courseId): Collection|array
    {

        return $this->courseReviewRepository->getAllByCourseId($courseId);
    }
}
