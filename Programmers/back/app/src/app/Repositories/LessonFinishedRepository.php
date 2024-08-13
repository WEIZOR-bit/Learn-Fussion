<?php

namespace app\Repositories;

class LessonFinishedRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  LessonFinishedRepository  $lessonFinished
     * @return void
     */
    public function __construct(LessonFinishedRepository $lessonFinished)
    {
        $this->model = $lessonFinished;
    }
}
