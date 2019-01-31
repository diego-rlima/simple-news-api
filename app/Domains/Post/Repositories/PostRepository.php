<?php

namespace App\Domains\Post\Repositories;

use App\Domains\Post\Models\Post;
use App\Support\Domains\Search\Search;
use App\Support\Domains\Search\Advanced;
use App\Support\Domains\Repositories\Repository;

class PostRepository extends Repository
{
    /**
     * Model class for repo.
     *
     * @var string
     */
    protected $modelClass = Post::class;

    /**
     * Columns that will be used in simple search.
     *
     * @var array
     */
    protected $searchable = ['title', 'content'];

    /**
     * Synchronize the categories of a post.
     *
     * @param  \App\Domains\Post\Models\Post  $post
     * @param array $categories
     */
    public function syncCategories(Post $post, array $categories): void
    {
        $post->categories()->sync($categories);
    }

    /**
     * Creates a new record in database.
     *
     * @param  array  $data
     * @return \App\Domains\Post\Models\Post
     */
    public function create(array $data = [])
    {
        $post = parent::create($data);

        if ($post) {
            auth()->user()->posts()->save($post);
        }

        return $post;
    }

    /**
     * Retrieves a record by his slug.
     * If $fail is true fires ModelNotFoundException when no record isn't found.
     *
     * @param  string  $slug
     * @param  bool    $fail
     * @return \App\Domains\Post\Models\Post
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

    /**
     * Function to format values for search in certain columns.
     *
     * @param  \App\Support\Domains\Search\Search  $search
     * @return void
     */
    protected function searchColumnMutators(Search $search)
    {
        $search->addMutator('author_id', function ($term) {
            if (!$term) {
                return null;
            }

            return decode_id($term) ?? $term;
        });
    }

    /**
     * Add settings for advanced search.
     *
     * @param  \App\Support\Domains\Search\Advanced  $search
     * @return void
     */
    protected function searchAdvancedSettings(Advanced $search)
    {
        $search->addColumn('author', 'author_id', '=')
            ->addRelationship('category', 'categories', function ($query, $value) {
                $id = decode_id($value) ?? $value;

                $query->where('id', $id);
            });
    }
}
