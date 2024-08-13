<?php

namespace app\Repositories;

use app\Models\HomeworkFinished;

class HomeworkFinishedRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  HomeworkFinished  $homeworkFinished
     * @return void
     */
    public function __construct(HomeworkFinished $homeworkFinished)
    {
        $this->model = $homeworkFinished;
    }
}
