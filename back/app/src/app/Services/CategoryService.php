<?php

namespace App\Services;

use App\Models\Category;
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
     * Get a Category by ID.
     *
     * @param int $id
     * @return null|Category
     */
    public function getById(int $id): ?Category
    {
        return $this->categoryRepository->get(['id' => $id]);
    }

    /**
     * Get all categories, optionally paginated.
     *
     * @return LengthAwarePaginator|Collection
     */
    public function all()
    {
        Log::debug( $this->categoryRepository->all());
        return $this->categoryRepository->all();
    }

    /**
     * Create a new Category.
     *
     * @param array $data
     * @return Category
     */
    public function create(array $data): Category
    {
        return $this->categoryRepository->create($data);
    }

    /**
     * Update an existing Category by ID.
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
     * Delete a Category by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->categoryRepository->delete($this->getById($id));
    }
}
