<?php

namespace app\Repositories;

use app\Models\HomeworkLesson;

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
}
