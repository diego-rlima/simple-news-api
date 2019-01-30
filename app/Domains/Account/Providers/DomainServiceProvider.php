<?php

namespace App\Domains\Account\Providers;

use App\Support\Domains\ServiceProvider;
use App\Domains\Account\Database\Seeders;
use App\Domains\Account\Database\Factories;
use App\Domains\Account\Database\Migrations;

class DomainServiceProvider extends ServiceProvider
{
    protected $alias = 'users';

    protected $migrations = [
        Migrations\CreateUsersTable::class,
        Migrations\CreatePasswordResetsTable::class,
    ];

    protected $seeders = [
        Seeders\UserSeeder::class,
    ];

    protected $factories = [
        Factories\UserFactory::class,
    ];
}
