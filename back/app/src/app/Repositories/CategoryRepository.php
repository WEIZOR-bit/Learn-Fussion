<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Challenge;

class CategoryRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  Challenge  $challenge
     * @return void
     */
    public function __construct(Category $category)
    {
        $this->model = $category;
    }
}
