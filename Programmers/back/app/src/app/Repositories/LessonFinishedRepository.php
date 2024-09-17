<?php

namespace app\Repositories;

use Illuminate\Database\Eloquent\Collection;

class LessonFinishedRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  LessonFinishedRepository  $lessonFinished
     * @return void
     */
    public function __construct(LessonFinishedRepository $lessonFinished)
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
