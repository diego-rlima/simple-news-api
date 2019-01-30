<?php

namespace App\Units\Core\Routes;

use App\Support\Http\Route;

class Api extends Route
{
    /**
     * Declare Api Routes.
     *
     * @return void
     */
    public function routes(): void
    {
        $this->router->get('/', 'WelcomeController@index')->name('index');
    }
}
