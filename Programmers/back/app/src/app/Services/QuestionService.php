<?php

namespace app\Services;

use App\Models\Question;
use App\Repositories\QuestionRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class QuestionService
{
    /**
     * Create a new service instance.
     *
     * @param  QuestionRepository  $questionRepository
     * @return void
     */
    public function __construct(private QuestionRepository $questionRepository)
    {
        //
    }

    /**
     * Get a question by ID.
     *
     * @param int $id
     * @return null|Question
     */
    public function getById(int $id): ?Question
    {
        return $this->questionRepository->get(['id' => $id]);
    }

    /**
     * Get all questions, optionally paginated.
     *
     * @param int|null $limit
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function getAllQuestions(?int $limit = null, array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->questionRepository->paginate($limit, $columns);
    }

    /**
     * Create a new question.
     *
     * @param array $data
     * @return Question
     */
    public function createQuestion(array $data): Question
    {
        return $this->questionRepository->create($data);
    }

    /**
     * Update an existing question by ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateQuestion(int $id, array $data): bool
    {
        return $this->questionRepository->update($this->getById($id), $data);
    }

    /**
     * Delete a question by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteQuestion(int $id): bool
    {
        return $this->questionRepository->delete($this->getById($id));
    }

    /**
     * Get the most recent questions.
     *
     * @param int|null $limit
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function getRecentQuestions(?int $limit = null, array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->questionRepository->paginate($limit, $columns);
    }
}
