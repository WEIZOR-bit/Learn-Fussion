<?php

namespace App\DTOs;

class CourseShortDTO
{
    public $id;
    public $name;
    public $category;
    public $author;
    public $published;
    public $cover_url;

    public function __construct($id, $name, $category, $author, $published, $cover_url)
    {
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
        $this->author = $author;
        $this->published = $published;
        $this->cover_url = $cover_url;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category,
            'author' => $this->author,
            'published' => $this->published,
            'cover_url' => $this->cover_url
        ];
    }
}
