<?php

namespace App\Support\Domains;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Migrator\MigratorTrait as HasMigrations;
use Illuminate\Support\ServiceProvider as DefaultServiceProvider;

abstract class ServiceProvider extends DefaultServiceProvider
{
    use HasMigrations;

    /**
     * Domain alias for resources.
     *
     * @var string
     */
    protected $alias;

    /**
     * List of domain providers to register.
     *
     * @var array
     */
    protected $subProviders;

    /**
     * List of migrations provided by Domain.
     *
     * @var array
     */
    protected $migrations = [];

    /**
     * List of seeders provided by Domain.
     *
     * @var array
     */
    protected $seeders = [];

    /**
     * List of model factories to load.
     *
     * @var array
     */
    protected $factories = [];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register the current Domain.
     *
     * @return void
     */
    public function register(): void
    {
        // Register Sub Providers
        $this->registerSubProviders(collect($this->subProviders));

        // Register migrations.
        $this->registerMigrations(collect($this->migrations));

        // Register seeders.
        $this->registerSeeders(collect($this->seeders));

        // Register model factories.
        $this->registerFactories(collect($this->factories));
    }

    /**
     * Register domain sub providers.
     *
     * @param  \Illuminate\Support\Collection  $subProviders
     * @return void
     */
    protected function registerSubProviders(Collection $subProviders): void
    {
        $subProviders->each(function ($provider) {
            $this->app->register($provider);
        });
    }

    /**
     * Register the defined migrations.
     *
     * @param  \Illuminate\Support\Collection  $migrations
     * @return void
     */
    protected function registerMigrations(Collection $migrations): void
    {
        $this->migrations($migrations->all());
    }

    /**
     * Register the defined seeders.
     *
     * @param  \Illuminate\Support\Collection  $seeders
     * @return void
     */
    protected function registerSeeders(Collection $seeders): void
    {
        $this->seeders($seeders->all());
    }

    /**
     * Register Model Factories.
     *
     * @param  \Illuminate\Support\Collection  $factories
     * @return void
     */
    protected function registerFactories(Collection $factories): void
    {
        $factories->each(function ($factoryName) {
            (new $factoryName())->define();
        });
    }

    /**
     * Detects the domain base path.
     *
     * @param  string  $append
     * @return string
     *
     * @throws \ReflectionException
     */
    protected function domainPath($append = null): string
    {
        $reflection = new \ReflectionClass($this);
        $realPath = realpath(dirname($reflection->getFileName()) . '/../');

        if (!$append) {
            return $realPath;
        }

        return $realPath . '/' . $append;
    }
}
