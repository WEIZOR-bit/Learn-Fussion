<?php

namespace App\Repositories;

use App\Models\LessonQuestion;

class LessonQuestionRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  LessonQuestion  $lessonQuestion
     * @return void
     */
    public function __construct(LessonQuestion $lessonQuestion)
    {
        $this->model = $lessonQuestion;
    }
}
