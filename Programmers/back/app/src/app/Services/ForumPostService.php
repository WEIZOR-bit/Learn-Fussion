<?php

namespace app\Services;

use app\Models\ForumPost;
use app\Repositories\ForumPostRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ForumPostService
{
    /**
     * Create a new service instance.
     *
     * @param  ForumPostRepository  $forumPostRepository
     * @return void
     */
    public function __construct(private ForumPostRepository $forumPostRepository)
    {
        //
    }

    /**
     * Get a ForumPost by ID.
     *
     * @param int $id
     * @return null|ForumPost
     */
    public function getById(int $id): ?ForumPost
    {
        return $this->forumPostRepository->get(['id' => $id]);
    }

    /**
     * Get all forum posts, optionally paginated.
     *
     * @param int|null $limit
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function all(?int $limit = null, array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->forumPostRepository->paginate($limit, $columns);
    }

    /**
     * Create a new ForumPost.
     *
     * @param array $data
     * @return ForumPost
     */
    public function create(array $data): ForumPost
    {
        return $this->forumPostRepository->create($data);
    }

    /**
     * Update an existing ForumPost by ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->forumPostRepository->update($this->getById($id), $data);
    }

    /**
     * Delete a ForumPost by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->forumPostRepository->delete($this->getById($id));
    }
}
