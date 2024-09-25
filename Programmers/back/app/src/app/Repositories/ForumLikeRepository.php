<?php

namespace App\Repositories;

use App\Models\ForumLike;

class ForumLikeRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  ForumLike  $forumLike
     * @return void
     */
    public function __construct(ForumLike $forumLike)
    {
        $this->model = $forumLike;
    }
}
