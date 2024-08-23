<?php

namespace App\Services;

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

    /**
     * Get a course by id.
     *
     * @param non-negative-int $id
     * @return null|Course
     */
    public function getById(int $id): ?Course
    {
        return $this->courseRepository->get(['id' => $id]);
    }

    public function getAllCourses()
    {
        return $this->courseRepository->all();
    }

    public function createCourse(array $data)
    {
        return $this->courseRepository->create($data);
    }

    public function updateCourse($id, array $data)
    {
        return $this->courseRepository->update($this->getById($id), $data);
    }
    public function deleteCourse($id)
    {
        return $this->courseRepository->delete($this->getById($id));
    }

}
