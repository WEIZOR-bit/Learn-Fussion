<?php

namespace App\Repositories;

use App\Models\ChallengeCompleted;

class ChallengeCompletedRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  ChallengeCompleted  $challengeCompleted
     * @return void
     */
    public function __construct(ChallengeCompleted $challengeCompleted)
    {
        $this->model = $challengeCompleted;
    }
}
