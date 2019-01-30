<?php

namespace App\Domains\Account\Repositories;

use App\Domains\Account\Models\User;
use App\Support\Domains\Repositories\Repository;

class UserRepository extends Repository
{
    /**
     * Model class for repo.
     *
     * @var string
     */
    protected $modelClass = User::class;
}
