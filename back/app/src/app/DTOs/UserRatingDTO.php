<?php

namespace App\DTOs;

class UserRatingDTO
{
    public $name;
    public $masteryLevel;

    public function __construct($name, $masteryLevel)
    {
        $this->name = $name;
        $this->masteryLevel = $masteryLevel;
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'masteryLevel' => $this->masteryLevel,
        ];
    }
}
