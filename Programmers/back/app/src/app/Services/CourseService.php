<?php

namespace app\Services;

use App\Models\Course;
use App\Repositories\CourseRepository;

class CourseService
{
    /**
     * Create a new service instance.
     *
     * @param  CourseRepository  $courseRepository
     * @return void
     */
    public function __construct(private CourseRepository $courseRepository)
    {
        //
    }

    /**
     * Get a course by name.
     *
     * @param  string $name
     * @return null|Course
     */
    public function getByName(string $name): ?Course
    {
        return $this->courseRepository->get(['name' => $name]);
    }
}
