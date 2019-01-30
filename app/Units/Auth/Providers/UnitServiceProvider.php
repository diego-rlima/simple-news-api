<?php
namespace App\Units\Auth\Providers;

use App\Support\Units\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    /**
     * Unit Alias for Translations and Views.
     *
     * @var string
     */
    protected $alias = 'auth';

    /**
     * List of Unit Service Providers to Register.
     *
     * @var array
     */
    protected $providers = [
        AuthServiceProvider::class,
        RouteServiceProvider::class,
    ];
}
