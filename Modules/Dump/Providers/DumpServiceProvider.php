<?php

namespace Modules\Dump\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Dump\Entities\Dump;
use Modules\Dump\Repositories\DumpRepository;

class DumpServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerRoutes();
        $this->registerViews();
    }

    public function register()
    {
        $this->providers();
        $this->eventProviders();
    }

    public function registerRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
    }

    public function registerViews()
    {
        $this->loadViewsFrom(resource_path('views/modules/dump'), 'dump');
    }

    public function providers()
    {
        $this->app->bind('Modules\Dump\Interfaces\DumpRepositoryInterface', function ($app) {
            return new DumpRepository(new Dump());
        });
    }

    public function eventProviders()
    {
        $this->app->register("Modules\Dump\Providers\EventProviders\DumpEventServiceProvider");
    }

    public function registerConfig()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php', 'dump'
        );
    }
}
