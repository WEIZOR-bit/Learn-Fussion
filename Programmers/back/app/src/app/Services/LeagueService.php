<?php

namespace app\Services;

use app\Repositories\LeagueRepository;

class LeagueService
{
    /**
     * Create a new service instance.
     *
     * @param  LeagueRepository  $leagueRepository
     * @return void
     */
    public function __construct(private LeagueRepository $leagueRepository)
    {
        //
    }

    public function all()
    {
        return $this->leagueRepository->all();
    }
    public function create(array $data)
    {
        return $this->leagueRepository->create($data);
    }

    public function getById($id)
    {
        return $this->leagueRepository->findOrFail($id);
    }
    public function update($id, array $data): bool
    {
        return $this->leagueRepository->update($id, $data);
    }
    public function delete($id): ?bool
    {
        return $this->leagueRepository->delete($id);
    }
}
