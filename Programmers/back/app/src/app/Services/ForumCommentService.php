<?php

namespace app\Services;

use app\Models\ForumComment;
use app\Repositories\ForumCommentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ForumCommentService
{
    /**
     * Create a new service instance.
     *
     * @param  ForumCommentRepository  $forumCommentRepository
     * @return void
     */
    public function __construct(private ForumCommentRepository $forumCommentRepository)
    {
        //
    }

    /**
     * Get a ForumComment by ID.
     *
     * @param int $id
     * @return null|ForumComment
     */
    public function getById(int $id): ?ForumComment
    {
        return $this->forumCommentRepository->get(['id' => $id]);
    }

    /**
     * Get all comments for the forum, optionally paginated.
     *
     * @param int|null $limit
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function all(?int $limit = null, array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->forumCommentRepository->paginate($limit, $columns);
    }

    /**
     * Create a new ForumComment.
     *
     * @param array $data
     * @return ForumComment
     */
    public function create(array $data): ForumComment
    {
        return $this->forumCommentRepository->create($data);
    }

    /**
     * Update an existing ForumComment by ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->forumCommentRepository->update($this->getById($id), $data);
    }

    /**
     * Delete a ForumComment by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->forumCommentRepository->delete($this->getById($id));
    }
}
