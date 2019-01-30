<?php

namespace App\Units\Core\Providers;

use Carbon\Carbon;
use App\Support\Units\ServiceProvider;
use Illuminate\Http\Resources\Json\Resource;

class UnitServiceProvider extends ServiceProvider
{
    /**
     * Unit Alias for Translations and Views.
     *
     * @var string
     */
    protected $alias = 'core';

    /**
     * List of Unit Service Providers to Register.
     *
     * @var array
     */
    protected $providers = [
        //BroadcastServiceProvider::class,
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     * @throws \ReflectionException
     */
    public function boot(): void
    {
        parent::boot();

        setlocale(LC_TIME, 'pt_BR.utf8');
        Carbon::setLocale(config('app.locale'));
        Resource::withoutWrapping();
    }
}
