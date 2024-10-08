<?php

namespace App\Repositories;

use App\Models\Answer;

class AnswerRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  Answer  $answer
     * @return void
     */
    public function __construct(Answer $answer)
    {
        $this->model = $answer;
    }
}
