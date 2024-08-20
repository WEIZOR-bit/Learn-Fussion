<?php

namespace App\Services;

use App\Repositories\LessonRepository;

class LessonService
{
    /**
     * Create a new service instance.
     *
     * @param  LessonRepository  $lessonRepository
     * @return void
     */
    public function __construct(private LessonRepository $lessonRepository)
    {
        //
    }

    public function getAllLessons()
    {
        return $this->lessonRepository->all();
    }
    public function createLesson(array $data)
    {
        return $this->lessonRepository->create($data);
    }

    public function getLessonById($id)
    {
        return $this->lessonRepository->find($id);
    }
    public function updateLesson($id, array $data)
    {
        return $this->lessonRepository->update($id, $data);
    }
    public function deleteLesson($id)
    {
        return $this->lessonRepository->delete($id);
    }

}
