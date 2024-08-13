<?php

namespace App\Services;

use App\Repositories\QuestionRepository;

class QuestionService
{
    /**
     * Create a new service instance.
     *
     * @param  QuestionRepository  $questionRepository
     * @return void
     */
    public function __construct(private QuestionRepository $questionRepository)
    {
        //
    }
}
