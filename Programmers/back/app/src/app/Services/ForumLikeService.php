<?php

namespace app\Services;

use app\Models\ForumLike;
use app\Repositories\ForumLikeRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ForumLikeService
{
    /**
     * Create a new service instance.
     *
     * @param  ForumLikeRepository  $forumLikeRepository
     * @return void
     */
    public function __construct(private ForumLikeRepository $forumLikeRepository)
    {
        //
    }

    /**
     * Get a ForumLike by ID.
     *
     * @param int $id
     * @return null|ForumLike
     */
    public function getById(int $id): ?ForumLike
    {
        return $this->forumLikeRepository->get(['id' => $id]);
    }

    /**
     * Get all forum likes, optionally paginated.
     *
     * @param int|null $limit
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function all(?int $limit = null, array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->forumLikeRepository->paginate($limit, $columns);
    }

    /**
     * Create a new ForumLike.
     *
     * @param array $data
     * @return ForumLike
     */
    public function create(array $data): ForumLike
    {
        return $this->forumLikeRepository->create($data);
    }

    /**
     * Update an existing ForumLike by ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->forumLikeRepository->update($this->getById($id), $data);
    }

    /**
     * Delete a ForumLike by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->forumLikeRepository->delete($this->getById($id));
    }
}
