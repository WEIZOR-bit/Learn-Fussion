<?php

namespace App\Services;

use App\Repositories\FriendRepository;

class FriendService
{
    private $friendRepository;

    public function __construct(FriendRepository $friendRepository)
    {
        $this->friendRepository = $friendRepository;
    }

    public function add(int $userId1, int $userId2)
    {

        if ($this->areFriends($userId1, $userId2)) {
            return false;
            // TODO handle differently perhaps
        }

        return $this->friendRepository->create([
            'user_id_1' => $userId1,
            'user_id_2' => $userId2,
        ]);
    }

    public function delete(int $userId1, int $userId2): bool
    {
        if (!$this->areFriends($userId1, $userId2)) {
            return false;
        }

        return $this->friendRepository->deleteFriendship($userId1, $userId2);
    }

    public function areFriends(int $userId1, int $userId2): bool
    {
        return $this->friendRepository->exists($userId1, $userId2);
    }
}
