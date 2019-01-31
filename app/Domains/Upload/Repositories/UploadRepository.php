<?php

namespace App\Domains\Upload\Repositories;

use App\Domains\Upload\Models\Upload;
use App\Support\Domains\Repositories\Repository;

class UploadRepository extends Repository
{
    /**
     * Model class for repo.
     *
     * @var string
     */
    protected $modelClass = Upload::class;
}
