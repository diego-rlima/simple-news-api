<?php

namespace App\Domains\Post\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Post\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        factory(Category::class, 20)->create();
    }
}
