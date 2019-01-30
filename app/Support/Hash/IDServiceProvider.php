<?php

namespace App\Support\Hash;

use Illuminate\Support\ServiceProvider;

class IDServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton('hash.id', function () {
            return new ID();
        });
    }
}
