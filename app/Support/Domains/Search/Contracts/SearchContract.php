<?php

namespace App\Support\Domains\Search\Contracts;


interface SearchContract
{
    /**
     * Search items from DB.
     *
     * @param  bool      $advanced
     * @param  int       $take
     * @param  bool      $paginate
     * @param  callable  $settings
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\AbstractPaginator
     */
    public function search(bool $advanced = false, int $take = 15, bool $paginate = true, callable $settings = null);
}
