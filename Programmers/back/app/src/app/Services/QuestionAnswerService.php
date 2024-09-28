<?php

namespace App\Services;

use App\Models\QuestionAnswer;
use App\Repositories\QuestionAnswerRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class QuestionAnswerService
{
    /**
     * Create a new service instance.
     *
     * @param  QuestionAnswerRepository  $questionAnswerRepository
     * @return void
     */
    public function __construct(private QuestionAnswerRepository $questionAnswerRepository)
    {
        //
    }

    /**
     * Get a QuestionAnswer by ID.
     *
     * @param int $id
     * @return null|QuestionAnswer
     */
    public function getById(int $id): ?QuestionAnswer
    {
        return $this->questionAnswerRepository->get(['id' => $id]);
    }

    /**
     * Get all question-answer pairs, optionally paginated.
     *
     * @param int|null $limit
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function all(?int $limit = null, array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->questionAnswerRepository->paginate($limit, $columns);
    }

    /**
     * Create a new QuestionAnswer.
     *
     * @param array $data
     * @return QuestionAnswer
     */
    public function create(array $data): QuestionAnswer
    {
        return $this->questionAnswerRepository->create($data);
    }

    /**
     * Update an existing QuestionAnswer by ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->questionAnswerRepository->update($this->getById($id), $data);
    }

    /**
     * Delete a QuestionAnswer by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->questionAnswerRepository->delete($this->getById($id));
    }
}
