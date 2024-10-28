<?php

namespace App\Services;

use App\DTOs\CourseShortDTO;
use App\Models\Course;
use App\Repositories\CourseRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;


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
        return $this->courseRepository->getAllCourses();
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

    public function deleteCover(int $id): bool {
        $course =$this->courseRepository->get(['id' => $id]);
        if ($course && $course->cover_url) {
            $oldPath = str_replace('http://0.0.0.0/storage/public/', '', $course->cover_url);
            Storage::disk('minio_public')->delete($oldPath);

            $course->cover_url = '';
            $course->save();

            return true;
        }

        return false;

    }


    public function search(string $query): LengthAwarePaginator
    {
        $paginator = $this->courseRepository->search($query);


        $coursesDTO = $paginator->getCollection()->map(function ($course) {
            return new CourseShortDTO(
                $course->id,
                $course->name,
                $course->category,
                $course->creator->name,
                $course->published,
                $course->cover_url
            );
        });

        return new LengthAwarePaginator(
            $coursesDTO,
            $paginator->total(),
            $paginator->perPage(),
            $paginator->currentPage(),
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
    }

}
