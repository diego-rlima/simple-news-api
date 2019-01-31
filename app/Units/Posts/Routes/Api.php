<?php

namespace App\Units\Posts\Routes;

use App\Support\Http\Route;

/**
 * Posts API routes.
 */
class Api extends Route
{
    /**
     * Declare API Routes.
     *
     * @return void
     */
    public function routes(): void
    {
        $this->categoriesRoutes();
        $this->postsRoutes();
    }

    /**
     * Categories routes.
     *
     * @return void
     */
    protected function categoriesRoutes(): void
    {
        $this->router->get('/', 'CategoryController@index');
        $this->router->post('/', 'CategoryController@store');
        $this->router->get('/{id}', 'CategoryController@show');
        $this->router->patch('/{id}', 'CategoryController@update');
        $this->router->delete('/{id}', 'CategoryController@destroy');
    }

    /**
     * Posts routes.
     *
     * @return void
     */
    protected function postsRoutes(): void
    {
        $this->router->get('/', 'PostController@index');
        $this->router->post('/', 'PostController@store');
        $this->router->get('/{post}', 'PostController@show');
        $this->router->patch('/{id}', 'PostController@update');
        $this->router->delete('/{id}', 'PostController@destroy');
    }
}
