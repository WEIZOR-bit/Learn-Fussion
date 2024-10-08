<?php

namespace App\Repositories;

use App\Models\QuestionAnswer;

class QuestionAnswerRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  QuestionAnswer  $questionAnswer
     * @return void
     */
    public function __construct(QuestionAnswer $questionAnswer)
    {
        $this->model = $questionAnswer;
    }
}
