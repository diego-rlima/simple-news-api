<?php

namespace App\Units\Auth\Http\Controllers;

use Illuminate\Http\Request;
use App\Support\Http\Response;
use App\Support\Http\ApiController;
use App\Domains\Account\Auth as AuthService;
use App\Units\Auth\Http\Requests\AuthRequest;

class AuthController extends ApiController
{
    /**
     * The AuthService instance.
     *
     * @var AuthService
     */
    protected $service;

    /**
     * Create a AuthController instance.
     *
     * @param  Response      $response
     * @param  AuthService  $service
     */
    public function __construct(Response $response, AuthService $service)
    {
        $this->response = $response;
        $this->service = $service;

        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  AuthRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthRequest $request)
    {
        // We tried to log in.
        $auth = $this->service->login($request);

        // We check if the login is locked out.
        if ($locked = $this->service->isLocked($request)) {
            return $this->response->withTooManyRequests(
                trans('auth.throttle', ['seconds' => $locked])
            );
        }

        // We checked for authentication error.
        if (!$auth) {
            return $this->response->withUnauthorized(trans('auth.failed'));
        }

        // We are logged in. Tell everyone. :)
        return $this->response->json(array_wrap($auth));
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->response->json(
            $this->service->refreshToken()
        );
    }

    /**
     * Handle a logout request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->service->logout($request);

        return $this->response->withNoContent();
    }
}
