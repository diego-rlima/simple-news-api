<?php

namespace App\Domains\Upload\Providers;

use App\Support\Domains\ServiceProvider;
use App\Domains\Upload\Database\Migrations;

class DomainServiceProvider extends ServiceProvider
{
    protected $alias = 'uploads';

    protected $migrations = [
        Migrations\CreateUploadsTable::class,
    ];
}
