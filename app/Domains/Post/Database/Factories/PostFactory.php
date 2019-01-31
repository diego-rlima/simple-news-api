<?php

namespace App\Domains\Post\Database\Factories;

use App\Domains\Post\Models\Post;
use App\Support\Domains\Database\Factory;

class PostFactory extends Factory
{
    /**
     * Factory for the Category Model.
     *
     * @var \App\Domains\Post\Models\Category
     */
    protected $model = Post::class;

    /**
     * Array with all fields.
     *
     * @return array
     */
    public function fields(): array
    {
        $title = $this->faker->unique()->sentence(4);

        return [
            'title' => $title,
            'slug' => str_slug($title, '-'),
            'content' => $this->faker->text(500)
        ];
    }
}
