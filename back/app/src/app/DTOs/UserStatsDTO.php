<?php
namespace App\DTOs;

class UserStatsDTO
{
public $hearts;
public $streakDays;
public $masteryLevel;
public $completedCourses;

public function __construct($hearts, $streakDays, $masteryLevel, array $completedCourses = [])
{
$this->hearts = $hearts;
$this->streakDays = $streakDays;
$this->masteryLevel = $masteryLevel;
$this->completedCourses = $completedCourses;
}

public function toArray()
{
return [
'hearts' => $this->hearts,
'streakDays' => $this->streakDays,
'masteryLevel' => $this->masteryLevel,
'completedCourses' => $this->completedCourses,
];
}
}
