<?php

namespace App\Repositories;

use App\Models\ChallengeUnchecked;

class HomeworkUncheckedRepository extends BaseRepository
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
     * Delete an entry by user_id and homework_id.
     *
     * @param int $userId
     * @param int $homeworkId
     * @return bool
     */
    public function deleteByUserIdAndHomeworkId(int $userId, int $homeworkId): bool
    {
        return $this->model->newQuery()
                ->where('user_id', $userId)
                ->where('homework_id', $homeworkId)
                ->delete() > 0;
    }
}
