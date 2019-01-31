<?php

namespace App\Units\Posts\Providers;

use App\Units\Posts\Routes\Api;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * @var string
     */
    protected $namespace = 'App\Units\Posts\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(): void
    {
        $this->mapApiRoutes();
    }

    /**
     * Define the "api" routes for the application.
     *
     * @return void
     */
    protected function mapApiRoutes(): void
    {
        (new Api([
            'middleware' => ['auth:api'],
            'namespace' => $this->namespace,
            'prefix' => 'posts',
            'as' => 'posts::',
        ]))->register();
    }
}
