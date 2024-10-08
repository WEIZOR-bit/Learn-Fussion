<?php

namespace App\Repositories;

use App\Models\Homework;

class HomeworkRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  Homework  $homework
     * @return void
     */
    public function __construct(Homework $homework)
    {
        $this->model = $homework;
    }
}
