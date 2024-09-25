<?php

namespace App\Repositories;

use App\Models\ForumComment;

class ForumCommentRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  ForumComment  $forumComment
     * @return void
     */
    public function __construct(ForumComment $forumComment)
    {
        $this->model = $forumComment;
    }
}
