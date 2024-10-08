<?php

namespace app\DTOs;

class LessonShortDTO
{
    public $id;
    public $name;
    public $completed;

    public function __construct($id, $name, $completed)
    {
        $this->id = $id;
        $this->name = $name;
        $this->completed = $completed;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'completed' => $this->completed,
        ];
    }
}
