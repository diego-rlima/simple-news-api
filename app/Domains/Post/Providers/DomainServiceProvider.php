<?php

namespace App\Domains\Post\Providers;

use App\Support\Domains\ServiceProvider;
use App\Domains\Post\Database\Seeders;
use App\Domains\Post\Database\Factories;
use App\Domains\Post\Database\Migrations;

class DomainServiceProvider extends ServiceProvider
{
    protected $alias = 'posts';

    protected $migrations = [
        Migrations\CreateCategoriesTable::class,
        Migrations\CreatePostsTables::class,
        Migrations\CreatePostCategoryTable::class,
    ];

    protected $seeders = [
        Seeders\CategorySeeder::class,
        Seeders\PostSeeder::class,
    ];

    protected $factories = [
        Factories\CategoryFactory::class,
        Factories\PostFactory::class,
    ];
}
