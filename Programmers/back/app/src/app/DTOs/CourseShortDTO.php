<?php

namespace App\DTOs;

class CourseShortDTO
{
    public $id;
    public $name;
    public $category;
    public $author;

    public function __construct($id, $name, $category,$author)
    {
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
        $this->author = $author;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category,
            'author' => $this->author,
        ];
    }
}
