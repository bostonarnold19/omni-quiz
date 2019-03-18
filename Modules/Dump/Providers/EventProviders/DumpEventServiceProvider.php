<?php

namespace Modules\Dump\Providers\EventProviders;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class DumpEventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'Modules\Dump\Events\SomeEvent' => [
            'Modules\Dump\Listeners\EventListener',
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}
