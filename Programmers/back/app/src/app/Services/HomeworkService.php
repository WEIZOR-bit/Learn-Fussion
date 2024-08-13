<?php

namespace App\Services;

use App\Repositories\HomeworkRepository;

class HomeworkService
{
    /**
     * Create a new service instance.
     *
     * @param  HomeworkRepository  $homeworkRepository
     * @return void
     */
    public function __construct(private HomeworkRepository $homeworkRepository)
    {
        //
    }
}
