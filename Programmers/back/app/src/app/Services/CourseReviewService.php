<?php

namespace app\Services;

use app\Repositories\CourseReviewRepository;

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
}
