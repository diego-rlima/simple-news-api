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

    /**
     * Retrieves a record by his slug.
     * If $fail is true fires ModelNotFoundException when no record isn't found.
     *
     * @param  string  $slug
     * @param  bool    $fail
     * @return \App\Domains\Post\Models\Category
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findBySlug(string $slug, bool $fail = false)
    {
        if ($fail) {
            return $this->newQuery()->where('slug', $slug)->firstOrFail();
        }

        return $this->newQuery()->where('slug', $slug)->first();
    }
}
