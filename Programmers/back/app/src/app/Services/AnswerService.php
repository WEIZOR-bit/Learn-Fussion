<?php

namespace App\Services;

use App\Models\Answer;
use App\Repositories\AnswerRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AnswerService
{
    /**
     * Create a new service instance.
     *
     * @param  AnswerRepository  $answerRepository
     * @return void
     */
    public function __construct(private AnswerRepository $answerRepository)
    {
        //
    }

    /**
     * Get an Answer by ID.
     *
     * @param int $id
     * @return null|Answer
     */
    public function getById(int $id): ?Answer
    {
        return $this->answerRepository->get(['id' => $id]);
    }

    /**
     * Get all answers, optionally paginated.
     *
     * @param int|null $limit
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function all(?int $limit = null, array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->answerRepository->paginate($limit, $columns);
    }

    /**
     * Create a new Answer.
     *
     * @param array $data
     * @return Answer
     */
    public function create(array $data): Answer
    {
        return $this->answerRepository->create($data);
    }

    /**
     * Update an existing Answer by ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->answerRepository->update($this->getById($id), $data);
    }

    /**
     * Delete an Answer by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->answerRepository->delete($this->getById($id));
    }
}
