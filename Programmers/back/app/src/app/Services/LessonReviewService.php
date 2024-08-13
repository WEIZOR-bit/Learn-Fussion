<?php

namespace app\Services;

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
}

