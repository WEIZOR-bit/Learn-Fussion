<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * Create a new instance.
     *
     * @param  Model  $model
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Retrieve all data of repository.
     *
     * @param  array  $columns
     * @return mixed
     */
    public function all($columns = ['*']): mixed
    {
        return $this->model->all($columns);
    }

    /**
     * Retrieve all data of repository, paginated, with optional filters.
     *
     * @param  null  $limit
     * @param array $columns
     * @param  array  $filters
     * @return mixed
     */
    public function paginate($limit = null, array $columns = ['*'], array $filters = []): mixed
    {
        $query = $this->model->select($columns);

        foreach ($filters as $filter) {
            $query->where($filter[0], $filter[1], $filter[2]);
        }

        return $query->latest()->paginate($limit);
    }

    /**
     * Save a new entity in repository.
     *
     * @param  array  $data
     * @return mixed
     */
    public function create(array $data): mixed
    {
        return $this->model->create($data);
    }

    /**
     * Return an entity.
     *
     * @param  int  $id
     * @return mixed
     */
    public function findOrFail(int $id): mixed
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Update an entity.
     *
     * @param  Model  $entity
     * @param  array  $data
     * @return bool
     */
    public function update(Model $entity, array $data): bool
    {
        return $entity->update($data);
    }

    /**
     * Delete an entity.
     *
     * @param  Model  $entity
     * @return bool|null
     */
    public function delete(Model $entity): bool|null
    {
        return $entity->delete();
    }

    /**
     * Update or create an entity.
     *
     * @param  array  $attributes
     * @param  array  $values
     * @return mixed
     */
    public function updateOrCreate(array $attributes, array $values): mixed
    {
        return $this->model->updateOrCreate($attributes, $values);
    }

    /**
     * Get entity.
     *
     * @param  array  $condition
     * @param  bool  $takeOne
     * @return mixed
     */
    public function get(array $condition = [], bool $takeOne = true): mixed
    {
        $result = $this->model->where($condition);

        if ($takeOne) {
            return $result->first();
        }

        return $result->get();
    }

    /**
     * Get courses based on specific criteria.
     *
     * @param array $criteria
     * @param int|null $limit
     * @return LengthAwarePaginator
     */
    public function getCoursesByCriteria(array $criteria = [], ?int $limit = null): LengthAwarePaginator
    {
        $query = $this->model->newQuery();

        if (!empty($criteria)) {
            $query->where($criteria[0], $criteria[1], $criteria[2]);
        }

        return $query->latest()->paginate($limit);
    }
}
