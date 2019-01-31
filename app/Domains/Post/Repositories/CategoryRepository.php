<?php

namespace App\Domains\Post\Repositories;

use App\Domains\Post\Models\Category;
use App\Support\Domains\Repositories\Repository;

class CategoryRepository extends Repository
{
    /**
     * Model class for repo.
     *
     * @var string
     */
    protected $modelClass = Category::class;
}
