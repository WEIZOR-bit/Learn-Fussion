<?php

namespace App\DTOs;

class UserStatsDTO
{
    public $hearts;
    public $streakDays;
    public $masteryLevel;

    public function __construct($hearts, $streakDays, $masteryLevel)
    {
        $this->hearts = $hearts;
        $this->streakDays = $streakDays;
        $this->masteryLevel = $masteryLevel;
    }

    public function toArray()
    {
        return [
            'hearts' => $this->hearts,
            'streakDays' => $this->streakDays,
            'masteryLevel' => $this->masteryLevel,
        ];
    }
}
