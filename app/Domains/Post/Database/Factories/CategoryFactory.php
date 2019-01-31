<?php

namespace App\Domains\Post\Database\Factories;

use App\Domains\Post\Models\Category;
use App\Support\Domains\Database\Factory;

class CategoryFactory extends Factory
{
    /**
     * Factory for the Category Model.
     *
     * @var \App\Domains\Post\Models\Category
     */
    protected $model = Category::class;

    /**
     * Array with all fields.
     *
     * @return array
     */
    public function fields(): array
    {
        $name = $this->faker->unique()->word;

        return [
            'name' => ucfirst($name),
            'slug' => $name,
        ];
    }
}
