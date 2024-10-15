<?php

namespace App\Services;

use App\Models\Answer;
use App\Repositories\AnswerRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class CategoryService
{
    /**
     * Create a new service instance.
     *
     * @param  CategoryRepository  $categoryRepository
     * @return void
     */
    public function __construct(private CategoryRepository $categoryRepository)
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
        return $this->categoryRepository->get(['id' => $id]);
    }

    /**
     * Get all answers, optionally paginated.
     *
     * @return LengthAwarePaginator|Collection
     */
    public function all()
    {
        Log::debug( $this->categoryRepository->all());
        return $this->categoryRepository->all();
    }

    /**
     * Create a new Answer.
     *
     * @param array $data
     * @return Answer
     */
    public function create(array $data): Answer
    {
        return $this->categoryRepository->create($data);
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
        return $this->categoryRepository->update($this->getById($id), $data);
    }

    /**
     * Delete an Answer by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->categoryRepository->delete($this->getById($id));
    }
}
