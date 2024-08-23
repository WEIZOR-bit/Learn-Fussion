<?php

namespace app\Repositories;

use app\Models\Subscription;

class SubscriptionRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  Subscription  $subscription
     * @return void
     */
    public function __construct(Subscription $subscription)
    {
        $this->model = $subscription;
    }
}
