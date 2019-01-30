<?php

namespace App\Units\Users\Http\Controllers;

use App\Support\Http\Response;
use App\Support\Http\Parameters;
use App\Support\Http\ApiController;
use App\Domains\Account\User as UserService;
use App\Units\Users\Http\Requests\CreateUserRequest;
use App\Units\Users\Http\Requests\UpdateUserRequest;
use App\Units\Users\Http\Requests\DestroyUserRequest;

class UserController extends ApiController
{
    /**
     * The UserService instance.
     *
     * @var UserService
     */
    protected $service;

    /**
     * Creates a new class instance.
     *
     * @param  \App\Support\Http\Response    $response
     * @param  \App\Support\Http\Parameters  $parameters
     * @param  \App\Domains\Account\User     $service
     */
    public function __construct(Response $response, Parameters $parameters, UserService $service)
    {
        parent::__construct($response, $parameters);
        $this->service = $service;
    }

    /**
     * List all users.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function index()
    {
        $sort = $this->parameters->sort();
        $order = $this->parameters->order();
        $limit = $this->parameters->limit();

        $users = $this->service->paginate($sort, $order, $limit);

        return $this->response->collection($users);
    }

    /**
     * Saves a new user to the database.
     *
     * @param  \App\Units\Users\Http\Requests\CreateUserRequest  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function store(CreateUserRequest $request)
    {
        $user = $this->service->create($request);

        return $this->response->withCreated($user);
    }

    /**
     * Updates an user.
     *
     * @param  \App\Units\Users\Http\Requests\UpdateUserRequest  $request
     * @param  string             $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $this->service->update($id, $request);

        return $this->response->withAccepted('Usuário atualizado com sucesso');
    }

    /**
     * Removes an user.
     *
     * @param  \App\Units\Users\Http\Requests\DestroyUserRequest  $request
     * @param  string                                             $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     */
    public function destroy(DestroyUserRequest $request, string $id)
    {
        $this->service->delete($id);

        return $this->response->withNoContent();
    }

    /**
     * Retrieve data from an user.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(string $id)
    {
        $user = $this->service->find($id);
        return $this->response->item($user);
    }
}
