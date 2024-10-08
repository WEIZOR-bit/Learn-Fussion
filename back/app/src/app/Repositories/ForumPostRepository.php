<?php

namespace App\Repositories;

use App\Models\ForumPost;

class ForumPostRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  ForumPost  $forumPost
     * @return void
     */
    public function __construct(ForumPost $forumPost)
    {
        $this->model = $forumPost;
    }
}
