<?php

namespace App\Support\Domains\Search;

use Illuminate\Support\Facades\Request;

class Advanced
{
    /**
     * The collection of queries.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $queries;

    /**
     * The search fields prefix.
     *
     * @var string
     */
    protected $prefix = 'sf_';

    /**
     * The query to be applied before the search query.
     *
     * @var callable|null
     */
    protected $beforeQuery;

    /**
     * The query to be applied after the search query.
     *
     * @var callable|null
     */
    protected $afterQuery;

    /**
     * The Search instance.
     *
     * @var Search
     */
    protected $builder;

    /**
     * Advanced constructor.
     *
     * @param Search $search
     */
    public function __construct(Search $search)
    {
        $this->builder = $search;
        $this->queries = collect([]);
    }

    /**
     * Apply the search query.
     *
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function query($query)
    {
        $query->where(function($query) {
            $this->applyBeforeQuery($query);

            $this->queries->each(function($field, $name) use ($query) {
                extract($field);

                // We verify if it is a relationship query.
                if (isset($relationship)) {
                    $value = Request::get($name);

                    if (empty($value)) {
                        return;
                    }

                    $query->whereHas($relationship, function ($query) use ($callback, $value) {
                        $callback($query, $value);
                    });

                    return;
                }

                $value = $this->builder->termFormatted(Request::get($name), $column, ($operator == 'like'));

                if ( !empty($value) || (!is_null($value) && intval($value) === 0 && $value !== '') ) {
                    if ( is_array($value) ) {
                        $query->whereIn($column, $value);
                    } else {
                        $query->where( $column, $operator, $value );
                    }
                }
            });

            $this->applyAfterQuery($query);
        });

        return $query;
    }

    /**
     * Add a column to be searched.
     *
     * @param  string  $name
     * @param  string  $column
     * @param  string  $operator
     * @return self
     */
    public function addColumn(string $name, string $column = null, string $operator = 'LIKE'): self
    {
        if (!$column) {
            $column = $name;
        }

        $name = $this->prefix . ucfirst($name);

        $this->queries->put($name, compact('column', 'operator'));

        return $this;
    }

    /**
     * Add a relationship to be searched.
     *
     * @param  string    $name
     * @param  string    $relationship
     * @param  callable  $callback
     * @return self
     */
    public function addRelationship(string $name, string $relationship, callable $callback): self
    {
        $name = $this->prefix . ucfirst($name);

        $this->queries->put($name, compact('relationship', 'callback'));

        return $this;
    }

    /**
     * Set a query to be applied before the search query.
     *
     * @param  callable  $callback
     * @return self
     */
    public function setBeforeQuery(callable $callback): self
    {
        $this->beforeQuery = $callback;

        return $this;
    }

    /**
     * Set the search fields prefix.
     *
     * @param  string  $prefix
     * @return self
     */
    public function setPrefix(string $prefix): self
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Set a query to be applied after the search query.
     *
     * @param  callable  $callback
     * @return self
     */
    public function setAfterQuery(callable $callback): self
    {
        $this->afterQuery = $callback;

        return $this;
    }

    /**
     * Apply a query before the search query.
     *
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder  $query
     * @return void
     */
    protected function applyBeforeQuery(&$query): void
    {
        if (is_callable($this->beforeQuery)) {
            call_user_func($this->beforeQuery, $query, $this->queries, $this->builder);
        }
    }

    /**
     * Apply a query after the search query.
     *
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder  $query
     * @return void
     */
    protected function applyAfterQuery(&$query): void
    {
        if (is_callable($this->afterQuery)) {
            call_user_func($this->afterQuery, $query, $this->queries, $this->builder);
        }
    }
}
