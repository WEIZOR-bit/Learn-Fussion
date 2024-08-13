<?php

namespace app\Services;

class HomeworkLessonService
{
    /**
     * Create a new service instance.
     *
     * @param  HomeworkLessonRepository  $homeworkLessonRepository
     * @return void
     */
    public function __construct(private HomeworkLessonRepository $homeworkLessonRepository)
    {
        //
    }
}
