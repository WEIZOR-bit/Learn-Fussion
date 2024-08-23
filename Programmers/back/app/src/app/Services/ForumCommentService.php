<?php

namespace app\Services;

use app\Repositories\ForumCommentRepository;

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
}
