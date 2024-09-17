<?php

namespace app\Repositories;

use app\Models\HomeworkLesson;
use Illuminate\Database\Eloquent\Collection;

class HomeworkLessonRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  HomeworkLesson  $homeworkLesson
     * @return void
     */
    public function __construct(HomeworkLesson $homeworkLesson)
    {
        $this->model = $homeworkLesson;
    }

    /**
     * Get all homeworks with a specific lesson.
     *
     * @param int $lessonId
     * @return Collection|array
     */
    public function getAllHomeworksForLesson(int $lessonId): Collection|array
    {
        return $this->model->newQuery()
            ->where('lesson_id', $lessonId)
            ->get();
    }

    /**
     * Get all lessons with a specific homework.
     *
     * @param int $homeworkId
     * @return Collection|array
     */
    public function getAllLessonsWithHomework(int $homeworkId): Collection|array
    {
        return $this->model->newQuery()
            ->where('homework_id', $homeworkId)
            ->get();
    }
}
