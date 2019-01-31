<?php

namespace App\Domains\Post\Repositories;

use App\Domains\Post\Models\Post;
use App\Support\Domains\Repositories\Repository;

class PostRespository extends Repository
{
    /**
     * Model class for repo.
     *
     * @var string
     */
    protected $modelClass = Post::class;
}
