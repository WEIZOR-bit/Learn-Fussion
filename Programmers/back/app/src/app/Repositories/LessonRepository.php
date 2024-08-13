<?php

namespace App\Repositories;

use App\Models\Lesson;

class LessonRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  Lesson  $lesson
     * @return void
     */
    public function __construct(Lesson $lesson)
    {
        $this->model = $lesson;
    }
}
