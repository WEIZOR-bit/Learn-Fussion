<?php

namespace App\Repositories;

use App\Models\LessonFinished;
use Illuminate\Database\Eloquent\Collection;

class LessonFinishedRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  LessonFinished  $courseFinished
     * @return void
     */
    public function __construct(LessonFinished $lessonFinished)
    {
        $this->model = $lessonFinished;
    }

    /**
     * Get all lessons finished by a specific user.
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
