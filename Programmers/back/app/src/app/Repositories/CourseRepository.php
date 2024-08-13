<?php

namespace app\Repositories;

use App\Models\Course;

class CourseRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  Course  $course
     * @return void
     */
    public function __construct(Course $course)
    {
        $this->model = $course;
    }
}
