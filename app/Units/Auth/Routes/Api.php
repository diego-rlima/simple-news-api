<?php

namespace App\Units\Auth\Routes;

use App\Support\Http\Route;

/**
 * Authentication API routes.
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
        $this->loginRoutes();

        $this->passwordRecoveryRoutes();

        $this->userRoutes();
    }

    /**
     * Routes related to password recovery.
     *
     * @return void
     */
    protected function passwordRecoveryRoutes(): void
    {
        // Sends a password recovery email.
        $this->router->post('password/recovery', 'ResetPasswordController@sendResetLinkEmail')->name('password-recovery');

        // Set's a new password based on the user's email and a reset token.
        $this->router->post('password/reset', 'ResetPasswordController@reset')->name('password-reset');
    }

    /**
     * Routes related with login, either credentials or token renewal.
     *
     * @return void
     */
    protected function loginRoutes(): void
    {
        // Login (generate a JWT token) from User's credentials (email and password).
        $this->router->post('login', 'AuthController@login')->name('login');

        // Login (generate a JWT token) from another, valid or renewable JWT token.
        $this->router->post('refresh', 'AuthController@refresh')->name('refresh');

        // Logout user.
        $this->router->post('logout', 'AuthController@logout')->name('logout');
    }

    /**
     * Routes related with authenticated user.
     *
     * @return void
     */
    protected function userRoutes(): void
    {
        // Get data about current authenticated user.
        $this->router->get('user', 'UserController@index')->name('profile');

        // Update the current authenticated user info.
        $this->router->patch('user', 'UserController@update')->name('update-profile');
    }
}
