<?php

namespace App\Providers;

use App\Observers\ApiCodeObserver;
use App\Observers\ConfirmationTokenObserver;
use App\Observers\UuidObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Illuminate\Auth\Events\Registered' => [
            'App\Listeners\RegisteredListener',
        ],
    ];

    /**
     * Map for models with observers
     *
     * @var array
     */
    protected $models = [
        \App\Models\User::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->registerUuidObservers();
        $this->registerApiCodeObservers();
        $this->registerConfirmationTokenObservers();
    }

    public function registerUuidObservers()
    {
        collect($this->models)->each(function($model) {

            /** @var \Illuminate\Database\Eloquent\Model $model */
            $model::observe(app(UuidObserver::class));
        });
    }

    public function registerApiCodeObservers()
    {
        collect($this->models)->each(function($model) {

            /** @var \Illuminate\Database\Eloquent\Model $model */
            $model::observe(app(ApiCodeObserver::class));
        });
    }

    public function registerConfirmationTokenObservers()
    {
        collect($this->models)->each(function($model) {

            /** @var \Illuminate\Database\Eloquent\Model $model */
            $model::observe(app(ConfirmationTokenObserver::class));
        });
    }
}
