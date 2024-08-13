<?php

namespace app\Repositories;

use app\Models\CourseFinished;

class CourseFinishedRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  CourseFinished  $courseFinished
     * @return void
     */
    public function __construct(CourseFinished $courseFinished)
    {
        $this->model = $courseFinished;
    }
}
