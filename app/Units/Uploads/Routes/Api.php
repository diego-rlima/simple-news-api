<?php

namespace App\Units\Uploads\Routes;

use App\Support\Http\Route;

/**
 * Uploads API routes.
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
        $this->router->get('/', 'UploadController@index');
        $this->router->post('/', 'UploadController@store');
        $this->router->get('/{id}', 'UploadController@show');
        $this->router->patch('/{id}', 'UploadController@update');
        $this->router->delete('/{id}', 'UploadController@destroy');
    }
}
