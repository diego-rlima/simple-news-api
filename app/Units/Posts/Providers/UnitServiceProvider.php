<?php

namespace App\Units\Posts\Providers;

use App\Support\Units\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    /**
     * Unit Alias for Translations and Views.
     *
     * @var string
     */
    protected $alias = 'posts';

    /**
     * List of Unit Service Providers to Register.
     *
     * @var array
     */
    protected $providers = [
        RouteServiceProvider::class,
    ];
}
