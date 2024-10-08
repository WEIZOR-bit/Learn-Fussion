<?php

namespace App\Repositories;

use App\Models\ChallengeUnchecked;

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

    /**
     * Delete an entry by user_id and challenge_id.
     *
     * @param int $userId
     * @param int $challengeId
     * @return bool
     */
    public function deleteByUserIdAndChallengeId(int $userId, int $challengeId): bool
    {
        return $this->model->newQuery()
                ->where('user_id', $userId)
                ->where('challenge_id', $challengeId)
                ->delete() > 0;
    }
}
