<?php

namespace App\DTOs;

class CourseDetailedDTO
{
    public $id;
    public $name;
    public $description;
    public $category;
    public $lessonsForUser;
    public $author;

    public function __construct($id, $name,$description, $category,$author,$lessonsForUser)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->category = $category;
        $this->author = $author;
        $this->lessonsForUser = $lessonsForUser;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category,
            'author' => $this->author,
            'lessonsForUser' => $this->lessonsForUser,
        ];
    }
}
