<?php

namespace app\Repositories;

use app\Models\Friend;

class FriendRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  Friend  $friend
     * @return void
     */
    public function __construct(Friend $friend)
    {
        $this->model = $friend;
    }

    public function exists(int $userId1, int $userId2): bool
    {
        return $this->model->where(function($query) use ($userId1, $userId2) {
            $query->where('user_id_1', $userId1)->where('user_id_2', $userId2);
        })->orWhere(function($query) use ($userId1, $userId2) {
            $query->where('user_id_1', $userId2)->where('user_id_2', $userId1);
        })->exists();
    }

    public function deleteFriendship(int $userId1, int $userId2): bool
    {
        return $this->model->where(function($query) use ($userId1, $userId2) {
                $query->where('user_id_1', $userId1)->where('user_id_2', $userId2);
            })->orWhere(function($query) use ($userId1, $userId2) {
                $query->where('user_id_1', $userId2)->where('user_id_2', $userId1);
            })->delete() > 0;
    }
}
