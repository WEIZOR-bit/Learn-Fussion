<?php

namespace App\Repositories;

use app\Models\CourseReview;
use Illuminate\Database\Eloquent\Collection;

class CourseReviewRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  CourseReview  $courseReview
     * @return void
     */
    public function __construct(CourseReview $courseReview)
    {
        $this->model = $courseReview;
    }

    /**
     * Get all reviews written by a specific user.
     *
     * @param int $userId
     * @return Collection|array
     */
    public function getAllByUserId(int $userId): Collection|array
    {
        return $this->model->newQuery()
            ->where('user_id', $userId)
            ->get();
    }

    /**
     * Get all reviews written for a specific course.
     *
     * @param int $courseId
     * @return Collection|array
     */
    public function getAllByCourseId(int $courseId): Collection|array
    {
        return $this->model->newQuery()
            ->where('course_id', $courseId)
            ->get();
    }
}
