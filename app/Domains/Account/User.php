<?php

namespace App\Domains\Account;

use Illuminate\Http\Request;
use App\Domains\Account\Events\UserCreated;
use App\Domains\Account\Events\UserUpdated;
use Illuminate\Pagination\AbstractPaginator;
use App\Domains\Account\Models\User as UserModel;
use App\Domains\Account\Repositories\UserRepository;

class User
{
    /**
     * The UserRepository instance.
     *
     * @var UserRepository
     */
    protected $repository;

    /**
     * The UserModel instance.
     *
     * @var UserModel
     */
    protected $model;

    /**
     * The User instance.
     */
    public function __construct(UserRepository $repository, UserModel $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }

    /**
     * Find an user.
     *
     * @param  string  $id
     * @return UserModel
     */
    public function find(string $id): UserModel
    {
        return $this->repository->findByPublicID($id, true);
    }

    /**
     * Create a new user.
     *
     * @param  Request  $request
     * @return UserModel
     */
    public function create(Request $request): UserModel
    {
        $data = $this->formatData($request);
        $user = $this->repository->create($data);

        event(new UserCreated($user));

        return $user;
    }

    /**
     * Update an user.
     *
     * @param  string   $id
     * @param  Request  $request
     * @return UserModel
     */
    public function update(string $id, Request $request): UserModel
    {
        $user = $this->find($id);
        $data = $this->formatData($request);

        $this->repository->update($user, $data);

        event(new UserUpdated($user));

        return $user;
    }

    /**
     * Paginating users.
     *
     * @param  string  $sort
     * @param  string  $order
     * @param  int     $limit
     * @return \Illuminate\Pagination\AbstractPaginator
     */
    public function paginate(string $sort, string $order, int $limit): AbstractPaginator
    {
        return $this->repository->doQuery(function($query) use ($sort, $order) {
            return $query->orderBy($sort, $order);
        }, $limit);
    }

    /**
     * Delete an user from database.
     *
     * @param  string   $id
     * @return void
     *
     * @throws \Exception
     */
    public function delete(string $id): void
    {
        $user = $this->find($id);
        $this->repository->delete($user);
    }

    /**
     * Format the user data.
     *
     * @param  Request  $request
     * @return array
     */
    protected function formatData(Request $request): array
    {
        return $request->only('name', 'email', 'password');
    }

    /**
     * Get the UserModel instance.
     *
     * @return \App\Domains\Account\Models\User
     */
    public function getModel(): UserModel
    {
        return $this->model;
    }

    /**
     * Get the UserRepository instance.
     *
     * @return \App\Domains\Account\Repositories\UserRepository
     */
    public function getRepository(): UserRepository
    {
        return $this->repository;
    }
}
