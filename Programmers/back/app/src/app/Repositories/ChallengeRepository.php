<?php

namespace app\Repositories;

use app\Models\Challenge;

class ChallengeRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  Challenge  $challenge
     * @return void
     */
    public function __construct(Challenge $challenge)
    {
        $this->model = $challenge;
    }
}
