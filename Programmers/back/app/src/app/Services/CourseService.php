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
     * Get a course by id.
     *
     * @param non-negative-int $id
     * @return null|Course
     */
    public function getById(int $id): ?Course
    {
        return $this->courseRepository->get(['id' => $id]);
    }

    public function getAllCourses(): mixed
    {
        return $this->courseRepository->all();
    }

    public function createCourse(array $data): mixed
    {
        return $this->courseRepository->create($data);
    }

    public function updateCourse($id, array $data): bool
    {
        return $this->courseRepository->update($this->getById($id), $data);
    }
    public function deleteCourse($id): ?bool
    {
        return $this->courseRepository->delete($this->getById($id));
    }

    public function exists(array $conditions): bool
    {
        return $this->courseRepository->exists($conditions);
    }

}
