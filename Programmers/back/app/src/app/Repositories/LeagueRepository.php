<?php

namespace app\Repositories;

use app\Models\League;

class LeagueRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  League  $league
     * @return void
     */
    public function __construct(League $league)
    {
        $this->model = $league;
    }
}
