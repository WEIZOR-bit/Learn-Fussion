<?php

namespace app\Repositories;

use App\Models\Question;

class QuestionRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  Question  $question
     * @return void
     */
    public function __construct(Question $question)
    {
        $this->model = $question;
    }
}
