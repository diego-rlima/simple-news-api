<?php

namespace App\Support\Domains\Search;

class Search
{
    /**
     * The Simple instance.
     *
     * @var Simple
     */
    protected $simple;

    /**
     * The Advanced instance.
     *
     * @var Advanced
     */
    protected $advanced;

    /**
     * Array with search mutators.
     *
     * @var array
     */
    protected $mutators = [];

    /**
     * Search constructor.
     */
    public function __construct()
    {
        $this->simple = new Simple($this);
    }

    /**
     * Add a mutator to list.
     *
     * @param  string    $column
     * @param  callable  $function
     * @return void
     */
    public function addMutator(string $column, callable $function)
    {
        $this->mutators[$column] = $function;
    }

    /**
     * Use the advanced search.
     *
     * @return void
     */
    public function useAdvanced()
    {
        if ( is_null($this->advanced) ) {
            $this->advanced = new Advanced($this);
        }
    }

    /**
     * Retrieves the formatted term.
     *
     * @param  mixed   $term
     * @param  string  $column
     * @param  bool    $formatToLike
     * @return mixed
     */
    public function termFormatted($term, string $column, bool $formatToLike = true)
    {
        if ( isset($this->mutators[$column]) ) {
            $term = call_user_func($this->mutators[$column], $term, $formatToLike);
        } elseif ( $formatToLike && !empty($term) ) {
            $term = '%' . $term . '%';
        }

        return $term;
    }

    /**
     * Apply the search query.
     *
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder  $query
     * @return mixed
     */
    public function query($query)
    {
        $this->simple->query($query);

        if ( $this->advanced ) {
            $this->advanced->query($query);
        }

        return $query;
    }

    /**
     * Get the Simple instance.
     *
     * @return Simple
     */
    public function getSimple()
    {
        return $this->simple;
    }

    /**
     * Get the Advanced instance.
     *
     * @return Advanced
     */
    public function getAdvanced()
    {
        return $this->advanced;
    }

    /**
     * Get the mutators array.
     *
     * @return array
     */
    public function getMutators()
    {
        return $this->mutators;
    }
}
