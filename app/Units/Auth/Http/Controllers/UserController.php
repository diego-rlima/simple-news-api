<?php

namespace App\Units\Auth\Http\Controllers;

use App\Support\Http\Response;
use App\Support\Http\ApiController;
use App\Domains\Account\User as UserService;
use App\Domains\Account\Resources\UserResource;
use App\Units\Auth\Http\Requests\UpdateAccountRequest;

class UserController extends ApiController
{
    /**
     * The currently authenticated user.
     *
     * @var \App\Domains\Account\Models\User
     */
    protected $user;

    /**
     * The user service instance.
     *
     * @var \App\Domains\Account\User
     */
    protected $service;

    /**
     * The user resource class.
     *
     * @var \App\Domains\Account\Resources\UserResource
     */
    protected $resource = UserResource::class;

    /**
     * Create a UserController instance.
     *
     * @param  \App\Support\Http\Response  $response
     * @param  \App\Domains\Account\User   $service
     */
    public function __construct(Response $response, UserService $service)
    {
        $this->response = $response;

        $this->middleware('auth:api');

        $this->user = auth()->user();
        $this->service = $service;
    }

    /**
     * Gets the logged user data.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function index()
    {
        return $this->response->item($this->user, $this->resource);
    }

    /**
     * Updates the logged user data.
     *
     * @param  UpdateAccountRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAccountRequest $request)
    {
        $this->service->update($this->user->publicId(), $request);

        return $this->response->withAccepted('Informações atualizadas com sucesso');
    }
}
