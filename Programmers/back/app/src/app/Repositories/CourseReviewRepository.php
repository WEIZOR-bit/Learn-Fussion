<?php

namespace app\Repositories;

use app\Models\CourseReview;

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
}
