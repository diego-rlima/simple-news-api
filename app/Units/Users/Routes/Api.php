<?php

namespace App\Units\Users\Routes;

use App\Support\Http\Route;

/**
 * Users API routes.
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
        $this->router->get('/', 'UserController@index');
        $this->router->post('/', 'UserController@store');
        $this->router->get('/{id}', 'UserController@show');
        $this->router->patch('/{id}', 'UserController@update');
        $this->router->delete('/{id}', 'UserController@destroy');
    }
}
