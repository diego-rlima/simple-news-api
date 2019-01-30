<?php

namespace App\Support\Domains\Search;

use Illuminate\Support\Facades\Request;

class Simple
{
    /**
     * Columns to search.
     *
     * @var array
     */
    protected $columns = [];

    /**
     * Variable to get the search value.
     *
     * @var string
     */
    protected $variable = 's';

    /**
     * The operator to search.
     *
     * @var string
     */
    protected $operator = 'LIKE';

    /**
     * The operator to search.
     *
     * @var string|null
     */
    protected $term;

    /**
     * The Search instance.
     *
     * @var Search
     */
    protected $builder;

    /**
     * Simple constructor.
     *
     * @param Search $search
     */
    public function __construct(Search $search)
    {
        $this->builder = $search;
    }

    /**
     * Get the columns to search.
     *
     * @return array|null
     */
    protected function columns(): ?array
    {
        $searchable = $this->columns;
        if (count($searchable) === 0) {
            return null;
        }

        $columns = array(
            'first' => array_shift($searchable),
            'others' => $searchable
        );

        return $columns;
    }

    /**
     * Apply the search to the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function query($query)
    {
        $columns = $this->columns();

        if ($columns && $this->term) {
            $query->where(function($query) use ($columns) {
                $column = $columns['first'];
                $query->where($column, $this->operator, $this->builder->termFormatted($this->term, $column));

                foreach ($columns['others'] as $column) {
                    $query->orWhere($column, $this->operator, $this->builder->termFormatted($this->term, $column));
                }
            });
        }

        return $query;
    }

    /**
     * Set the term to search.
     *
     * @param  string|null  $term
     * @return self
     */
    public function setTerm(string $term = null): self
    {
        if ( is_null($term) ) {
            $term = Request::get($this->variable);
        }

        $this->term = $term;

        return $this;
    }

    /**
     * Set the variable to get the search value.
     *
     * @param  string  $variable
     * @return self
     */
    public function setVariable(string $variable): self
    {
        $this->variable = $variable;

        return $this;
    }

    /**
     * Set the operator to search.
     *
     * @param  string  $operator
     * @return self
     */
    public function setOperator(string $operator): self
    {
        $this->operator = $operator;

        return $this;
    }

    /**
     * Set the columns to search.
     *
     * @param  array  $columns
     * @return self
     */
    public function setColumns(array $columns): self
    {
        $this->columns = $columns;

        return $this;
    }
}
