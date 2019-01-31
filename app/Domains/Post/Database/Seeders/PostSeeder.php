<?php

namespace App\Domains\Post\Database\Seeders;

use App\Domains\Account\Models\User;
use App\Domains\Post\Models\Category;
use Illuminate\Database\Seeder;
use App\Domains\Post\Models\Post;

class PostSeeder extends Seeder
{
    public function run()
    {
        $categories = $this->categories();
        $users = $this->users();

        factory(Post::class, 100)
            ->create()
            ->each(function ($post) use ($categories, $users) {
                $post->categories()->sync(
                    $categories->random(5)->map(function ($category) {
                    return $category->id;
                    })
                );

                $users->random()->posts()->save($post);
            }
        );
    }

    protected function categories()
    {
        return Category::all();
    }

    protected function users()
    {
        return User::all();
    }
}
