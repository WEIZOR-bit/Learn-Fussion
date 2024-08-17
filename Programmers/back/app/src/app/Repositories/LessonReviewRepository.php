<?php

namespace app\Repositories;

use app\Models\LessonReview;
use Illuminate\Database\Eloquent\Collection;

class LessonReviewRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  LessonReview  $lessonReview
     * @return void
     */
    public function __construct(LessonReview $lessonReview)
    {
        $this->model = $lessonReview;
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
     * Get all reviews written for a specific lesson.
     *
     * @param int $lessonId
     * @return Collection|array
     */
    public function getAllByLessonId(int $lessonId): Collection|array
    {
        return $this->model->newQuery()
            ->where('lesson_id', $lessonId)
            ->get();
    }
}
