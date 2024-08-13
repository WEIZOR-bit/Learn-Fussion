<?php

namespace app\Services;

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
}
