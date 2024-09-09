<?php

namespace app\Services;

use app\Models\League;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Date;

class UserService
{
    /**
     * Create a new service instance.
     *
     * @param  UserRepository  $userRepository
     * @return void
     */
    public function __construct(private UserRepository $userRepository)
    {
        //
    }

    /**
     * Store a new user.
     *
     * @param  array  $data
     * @return User
     */
    public function storeUser(array $data): User
    {
        return $this->userRepository->create($data);
    }

    /**
     * Get a user by email.
     *
     * @param  string  $email
     * @return null|User
     */
    public function getByEmail(string $email): ?User
    {
        return $this->userRepository->get(['email' => $email]);
    }

    /**
     * Get a user by id.
     *
     * @param non-negative-int $id
     * @return null|User
     */
    public function getById($id): ?User
    {
        return $this->userRepository->get(['id' => $id]);
    }

    /**
     * Get the number of days the user is in a streak.
     *
     * @param non-negative-int $id
     * @return int
     */
    public function getStreakDays(int $id): int
    {
        $user = $this->getById($id);
        $lastActive = strtotime($user->last_active_at);
        $today = strtotime(date('Y-m-d'));

        if (date('Y-m-d', $lastActive) !== date('Y-m-d', $today)) {
            return 0;
        }

        $startedStreak = strtotime($user->started_streak_at);

        $diffInSeconds = $lastActive - $startedStreak;
        $diffInDays = floor($diffInSeconds / (60 * 60 * 24));

        return $diffInDays + 1; // +1 to include the current day
    }

    /**
     * Update the last_active_at field to today and reset hearts.
     *
     * @param non-negative-int $id
     * @return bool
     */
    public function updateActivity(int $id): bool
    {
        $user = $this->getById($id);

        if ($user) {
            $user->last_active_at = Date::now();
            $user->hearts = 10;
            return $user->save();
        }

        return false;
    }

    /**
     * Get the league of a user based on their mastery level.
     *
     * @param int $userId
     * @return null|string
     */
    public function getUserLeague(int $userId): ?string
    {
        // Retrieve the user's mastery level
        $user = $this->getById($userId);

        if (!$user) {
            return null; // User not found
        }

        $masteryLevel = $user->mastery_level;

        // Find the highest league the user qualifies for
        return League::query()->where('min_mastery_level', '<=', $masteryLevel)
            ->orderByDesc('min_mastery_level')
            ->first()->name;
    }
}
