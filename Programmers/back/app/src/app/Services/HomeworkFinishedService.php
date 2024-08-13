<?php

namespace app\Services;

class HomeworkFinishedService
{
    /**
     * Create a new service instance.
     *
     * @param  HomeworkFinishedRepository  $homeworkFinishedRepository
     * @return void
     */
    public function __construct(private HomeworkFinishedRepository $homeworkFinishedRepository)
    {
        //
    }
}
