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
}
