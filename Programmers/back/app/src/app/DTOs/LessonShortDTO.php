<?php

namespace App\DTOs;

class LessonShortDTO
{
    public $id;
    public $order;
    public $name;
    public $question_count;
    public $completed;

    public function __construct($id, $order, $name, $questionCount, $completed)
    {
        $this->id = $id;
        $this->order = $order;
        $this->name = $name;
        $this->question_count = $questionCount;
        $this->completed = $completed;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'order' => $this->order,
            'name' => $this->name,
            'question_count' => $this->question_count,
            'completed' => $this->completed,
        ];
    }
}
