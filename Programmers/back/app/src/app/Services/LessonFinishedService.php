<?php

namespace app\Services;

class LessonFinishedService
{
    /**
     * Create a new service instance.
     *
     * @param  LessonFinishedRepository  $lessonFinishedRepository
     * @return void
     */
    public function __construct(private LessonFinishedRepository $questionRepository)
    {
        //
    }
}
