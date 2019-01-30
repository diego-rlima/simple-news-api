<?php

namespace App\Support\Domains\Database;

use Faker\Generator;
use Illuminate\Database\Eloquent\Factory as DefaultFactory;

abstract class Factory
{
    /**
     * @var \Illuminate\Database\Eloquent\Factory
     */
    protected $factory;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * @var \Faker\Generator
     */
    protected $faker;


    public function __construct()
    {
        $this->factory = app()->make(DefaultFactory::class);
        $this->faker = app()->make(Generator::class);
    }

    /**
     * Define the fields.
     *
     * @return void
     */
    public function define(): void
    {
        $this->factory->define($this->model, function () {
            return $this->fields();
        });
    }

    /**
     * Array with all fields.
     *
     * @return array
     */
    abstract public function fields(): array;
}
