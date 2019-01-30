<?php

namespace App\Support\Domains\Repositories;

use App\Support\Domains\Model;
use App\Support\Domains\Search\Search;
use App\Support\Domains\Search\Advanced;
use \Illuminate\Database\Eloquent\Collection;
use App\Support\Domains\Search\Contracts\SearchContract;
use App\Support\Domains\Repositories\Contracts\RepositoryContract;

abstract class Repository implements RepositoryContract, SearchContract
{
    /**
     * Model class for repo.
     *
     * @var string
     */
    protected $modelClass;

    /**
     * Relationships to eager load.
     *
     * @var array
     */
    protected $with = [];

    /**
     * Columns that will be used in simple search.
     *
     * @var array
     */
    protected $searchable = [];

    /**
     * Column(s) that will be selected.
     *
     * @var mixed
     */
    protected $select;

    /**
     * @var mixed
     */
    protected $trashed = false;

    /**
     * Specify a custom select clause for the query.
     *
     * @param  mixed  $value
     * @return self
     */
    public function select($value = null)
    {
        $this->select = $value;

        return $this;
    }

    /**
     * Creates a new query.
     *
     * @param  mixed  $query
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function newQuery($query = null)
    {
        if ($query === null) {
            $query = app()->make($this->modelClass)->newQuery();
        }

        if ($this->trashed === 'only') {
            $query->onlyTrashed();
        } elseif ($this->trashed === 'with') {
            $query->withTrashed();
        }

        if (!empty($this->with)) {
            $query->with($this->with);
        }

        if (!empty($this->select)) {
            $query->select($this->select);
        }

        return $query;
    }

    /**
     * Use eager loading.
     *
     * @param  array  $data
     * @return self
     */
    public function with(array $data)
    {
        $this->with = $data;

        return $this;
    }

    /**
     * Query against deleted records only.
     *
     * @return self
     */
    public function onlyTrashed()
    {
        $this->trashed = 'only';

        return $this;
    }

    /**
     * Query against all records, including deleted.
     *
     * @return self
     */
    public function withTrashed()
    {
        $this->trashed = 'with';

        return $this;
    }

    /**
     * Reset trashed state so results will only include non-deleted records.
     *
     * @return self
     */
    public function withoutTrashed()
    {
        $this->trashed = false;

        return $this;
    }

    /**
     * Executes a query and retrieve the results.
     *
     * @param  mixed      $query
     * @param  false|int  $take
     * @param  bool       $paginate
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\AbstractPaginator
     */
    public function doQuery($query = null, $take = 15, bool $paginate = true)
    {
        if (is_callable($query)) {
            $query = $query($this->newQuery());
        } else {
            $query = $this->newQuery($query);
        }

        if ($take == -1) {
            $take = $this->count();
        }

        if ($paginate === true) {
            return $query->paginate($take);
        }

        if ($take > 0 && $take !== false) {
            $query->take($take);
        }

        return $query->get();
    }

    /**
     * Creates a Model object with the $data information.
     *
     * @param  array  $data
     * @return \App\Support\Domains\Model
     */
    public function factory(array $data = [])
    {
        $model = $this->newQuery()->getModel()->newInstance();

        $this->setModelData($model, $data);

        return $model;
    }

    /**
     * Creates a new record in database.
     *
     * @param  array  $data
     * @return \App\Support\Domains\Model
     */
    public function create(array $data = [])
    {
        $model = $this->factory($data);

        $this->save($model);

        return $model;
    }

    /**
     * Performs the save method of the model
     * The goal is to enable the implementation of your business logic before the command.
     *
     * @param  \App\Support\Domains\Model  $model
     * @return bool
     */
    public function save(Model $model)
    {
        return $model->save();
    }

    /**
     * Returns all records.
     * If $take is false then brings all records
     * If $paginate is true returns Paginator instance.
     *
     * @param  false|int  $take
     * @param  bool       $paginate
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Pagination\AbstractPaginator
     */
    public function getAll($take = 15, bool $paginate = true)
    {
        return $this->doQuery(null, $take, $paginate);
    }

    /**
     * Retrieves a record by his public id.
     * If $fail is true fires ModelNotFoundException when no record isn't found.
     *
     * @param  string  $id
     * @param  bool    $fail
     * @return \App\Support\Domains\Model
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findByPublicID(string $id, bool $fail = false)
    {
        $id = decode_id($id);

        return $this->findByID($id, $fail);
    }

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
    public function findByID($id, bool $fail = false)
    {
        if ($fail) {
            return $this->newQuery()->findOrFail($id);
        }

        return $this->newQuery()->find($id);
    }

    /**
     * Updates the model data.
     *
     * @param  \App\Support\Domains\Model  $model
     * @param  array                       $data
     * @return bool
     */
    public function update(Model $model, array $data = [])
    {
        $this->setModelData($model, $data);

        return $this->save($model);
    }

    /**
     * Run the command to delete the model.
     *
     * @param  \App\Support\Domains\Model  $model
     * @param  bool                        $force
     * @return bool
     *
     * @throws \Exception
     */
    public function delete(Model $model, bool $force = false)
    {
        if ($force) {
            return $model->forceDelete();
        }

        return $model->delete();
    }

    /**
     * Run the delete command model.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $collection
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function deleteAll(Collection $collection)
    {
        return $collection->each(function ($item) {
            return $item->delete();
        });
    }

    /**
     * Run the restore command model.
     *
     * @param  \App\Support\Domains\Model  $model
     * @return bool
     */
    public function restore(Model $model)
    {
        return $model->restore();
    }

    /**
     * Populates the model with an array of attributes
     *
     * @param  \App\Support\Domains\Model  $model
     * @param  array                       $data
     * @return Model
     */
    protected function setModelData(Model $model, array $data)
    {
        return $model->fill($data);
    }

    /**
     * Count how many records exists in the database.
     *
     * @param  mixed  $query
     * @return int
     */
    public function count($query)
    {
        return $this->newQuery($query)->count();
    }

    /**
     * Determines if records exist in the database.
     *
     * @param  mixed  $query
     * @return bool
     */
    public function exists($query)
    {
        return $this->newQuery($query)->exists();
    }

    /**
     * Search items from DB.
     *
     * @param  bool      $advanced
     * @param  int       $take
     * @param  bool      $paginate
     * @param  callable  $settings
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\AbstractPaginator
     */
    public function search(bool $advanced = false, int $take = 15, bool $paginate = true, callable $settings = null)
    {
        $search = new Search();

        $search->getSimple()->setTerm(null); // Get term automatically
        $search->getSimple()->setColumns($this->searchable);

        $this->searchColumnMutators($search);

        if ( $advanced ) {
            $search->useAdvanced();
            $this->searchAdvancedSettings($search->getAdvanced());
        }

        $query = $this->newQuery();

        if (is_callable($settings)) {
            $settings($query, $search);
        }

        return $this->doQuery($search->query($query), $take, $paginate);
    }

    /**
     * Function to format values for search in certain columns.
     *
     * @param  \App\Support\Domains\Search\Search  $search
     * @return void
     */
    protected function searchColumnMutators(Search $search)
    {
        //
    }

    /**
     * Add settings for advanced search.
     *
     * @param  \App\Support\Domains\Search\Advanced  $search
     * @return void
     */
    protected function searchAdvancedSettings(Advanced $search)
    {
        //
    }
}
