<?php

namespace app\Services;

use App\Models\Course;
use App\Repositories\CourseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

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
     * Get a course by ID.
     *
     * @param int $id
     * @return null|Course
     */
    public function getById(int $id): ?Course
    {
        return $this->courseRepository->get(['id' => $id]);
    }

    /**
     * Get all courses, optionally paginated.
     *
     * @param int|null $limit
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function getAllCourses(?int $limit = null, array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->courseRepository->paginate($limit, $columns);
    }

    /**
     * Get courses by the admin who created them.
     *
     * @param int $adminId
     * @param int|null $limit
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function getCoursesByCreator(int $adminId, ?int $limit = null, array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->courseRepository->paginate($limit, $columns, [
            ['created_by', '=', $adminId]
        ]);
    }

    /**
     * Create a new course.
     *
     * @param array $data
     * @return Course
     */
    public function createCourse(array $data): Course
    {
        return $this->courseRepository->create($data);
    }

    /**
     * Update an existing course by ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateCourse(int $id, array $data): bool
    {
        return $this->courseRepository->update($this->getById($id), $data);
    }

    /**
     * Delete a course by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteCourse(int $id): bool
    {
        return $this->courseRepository->delete($this->getById($id));
    }

    /**
     * Get the most recent courses.
     *
     * @param int|null $limit
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function getRecentCourses(?int $limit = null, array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->courseRepository->paginate($limit, $columns);
    }
}
