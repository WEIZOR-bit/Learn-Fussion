<?php

namespace app\Repositories;

use app\Models\LessonReview;

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
}
