<?php

namespace App\Repositories;

use App\Models\CourseFinished;
use Illuminate\Database\Eloquent\Collection;

class CourseFinishedRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  CourseFinished  $courseFinished
     * @return void
     */
    public function __construct(CourseFinished $courseFinished)
    {
        $this->model = $courseFinished;
    }

    /**
     * Get all courses finished by a specific user.
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
