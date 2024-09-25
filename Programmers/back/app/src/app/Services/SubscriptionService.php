<?php

namespace App\Services;

use App\Models\Subscription;
use App\Repositories\SubscriptionRepository;
use Carbon\Carbon;

class SubscriptionService
{
    /**
     * Create a new service instance.
     *
     * @param  SubscriptionRepository  $subscriptionRepository
     * @return void
     */
    public function __construct(private SubscriptionRepository $subscriptionRepository)
    {
        //
    }

    /**
     * Check if a user is currently subscribed.
     *
     * @param  int  $userId
     * @return bool
     */
    public function isUserCurrentlySubscribed(int $userId): bool
    {
        $latestSubscription = $this->subscriptionRepository->get(['id' => $userId])
            ->where('user_id', $userId)
            ->orderByDesc('end_date')
            ->first();

        if ($latestSubscription) {
            $currentDate = Carbon::now();
            return $currentDate->between($latestSubscription->start_date, $latestSubscription->end_date);
        }

        return false;
    }

    /**
     * Add a subscription for the user.
     *
     * @param int $userId
     * @param int $months
     * @return mixed
     */
    public function addSubscription(int $userId, int $months): mixed
    {
        if (!$this->isUserCurrentlySubscribed($userId)) {
            $startDate = Carbon::now();
            $endDate = $startDate->copy()->addMonths($months);

            return $this->subscriptionRepository->create([
                'user_id' => $userId,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);
        }

        return false; // The user is already subscribed.
        // TODO handle already-present-subscription exception differently
    }
}
