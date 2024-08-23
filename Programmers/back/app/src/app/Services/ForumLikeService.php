<?php

namespace app\Services;

use app\Repositories\ForumLikeRepository;

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
}
