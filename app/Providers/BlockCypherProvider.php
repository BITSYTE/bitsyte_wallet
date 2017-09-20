<?php

namespace App\Providers;

use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;
use Illuminate\Support\ServiceProvider;

class BlockCypherProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ApiContext::class, function($app){
            $config = $app->make('config')->get('block_cypher');

            return ApiContext::create(
                $config['chain'],
                $config['coin'],
                $config['version'],
                new SimpleTokenCredential($config['key']),
                $config['config']
            );
        });
    }

    public function getCredentials($token)
    {
        return new SimpleTokenCredential($token);
    }
}
