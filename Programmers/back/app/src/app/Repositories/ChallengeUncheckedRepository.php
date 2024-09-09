<?php

namespace app\Repositories;

use app\Models\ChallengeUnchecked;

class ChallengeUncheckedRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  ChallengeUnchecked  $challengeUnchecked
     * @return void
     */
    public function __construct(ChallengeUnchecked $challengeUnchecked)
    {
        $this->model = $challengeUnchecked;
    }
}
