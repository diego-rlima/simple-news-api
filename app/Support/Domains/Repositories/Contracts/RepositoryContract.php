<?php

namespace App\Support\Domains\Repositories\Contracts;

use App\Support\Domains\Model;

interface RepositoryContract
{
    /**
     * Creates a new query.
     *
     * @param  mixed  $query
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function newQuery($query = null);

    /**
     * Creates a Model object with the $data information.
     *
     * @param  array  $data
     * @return \App\Support\Domains\Model
     */
    public function factory(array $data = []);

    /**
     * Creates a new record in database.
     *
     * @param  array  $data
     * @return \App\Support\Domains\Model
     */
    public function create(array $data = []);

    /**
     * Performs the save method of the model
     * The goal is to enable the implementation of your business logic before the command.
     *
     * @param  \App\Support\Domains\Model  $model
     * @return bool
     */
    public function save(Model $model);

    /**
     * Returns all records.
     * If $take is false then brings all records
     * If $paginate is true returns Paginator instance.
     *
     * @param  false|int  $take
     * @param  bool       $paginate
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Pagination\AbstractPaginator
     */
    public function getAll($take = 15, bool $paginate = true);

    /**
     * Retrieves a record by his id.
     * If $fail is true fires ModelNotFoundException when no record isn't found.
     *
     * @param  mixed  $id
     * @param  bool   $fail
     * @return \App\Support\Domains\Model
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findByID($id, bool $fail = true);

    /**
     * Updates the model data.
     *
     * @param  \App\Support\Domains\Model  $model
     * @param  array                       $data
     * @return bool
     */
    public function update(Model $model, array $data = []);

    /**
     * Run the command to delete the model.
     *
     * @param  \App\Support\Domains\Model  $model
     * @param  bool                        $force
     * @return bool
     */
    public function delete(Model $model, bool $force = false);

    /**
     * Query against deleted records only.
     *
     * @return self
     */
    public function onlyTrashed();

    /**
     * Query against all records, including deleted.
     *
     * @return self
     */
    public function withTrashed();

    /**
     * Reset trashed state so results will only include non-deleted records.
     *
     * @return self
     */
    public function withoutTrashed();

    /**
     * Run the restore command model.
     *
     * @param  \App\Support\Domains\Model  $model
     * @return bool
     */
    public function restore(Model $model);
}
