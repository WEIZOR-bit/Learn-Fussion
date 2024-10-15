<?php

namespace App\DTOs;

class CourseShortDTO
{
    public $id;
    public $name;
    public $category;
    public $author;
    public $published;

    public function __construct($id, $name, $category, $author, $published)
    {
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
        $this->author = $author;
        $this->published = $published;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category,
            'author' => $this->author,
            'published' => $this->published
        ];
    }
}
