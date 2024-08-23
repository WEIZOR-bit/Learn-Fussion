<?php

namespace app\Services;

use app\Repositories\ForumPostRepository;

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
}
