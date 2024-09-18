<?php

namespace App\Repositories;

use app\Models\HomeworkFinished;
use Illuminate\Database\Eloquent\Collection;

class HomeworkFinishedRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  HomeworkFinished  $homeworkFinished
     * @return void
     */
    public function __construct(HomeworkFinished $homeworkFinished)
    {
        $this->model = $homeworkFinished;
    }

    /**
     * Get all homeworks finished by a specific user.
     *
     * @param int $userId
     * @return Collection|array
     */
    public function getAllByUserId(int $userId): Collection|array
    {
        return $this->model->newQuery()
            ->where('user_id', $userId)
            ->get();
    }
}
