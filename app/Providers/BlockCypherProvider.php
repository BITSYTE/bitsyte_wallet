<?php

namespace App\Providers;

use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Client\AddressClient;
use BlockCypher\Client\FaucetClient;
use BlockCypher\Client\TXClient;
use BlockCypher\Client\WalletClient;
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

        $this->app->bind(WalletClient::class, function($app){
            $apiContext = $app->make(ApiContext::class);

            return new WalletClient($apiContext);
        });

        $this->app->bind(AddressClient::class, function($app){
            $apiContext = $app->make(ApiContext::class);

            return new AddressClient($apiContext);
        });

        $this->app->bind(TXClient::class, function($app){
            $apiContext = $app->make(ApiContext::class);

            return new TXClient($apiContext);
        });

        $this->app->bind(FaucetClient::class, function($app){
            $apiContext = $app->make(ApiContext::class);

            return new FaucetClient($apiContext);
        });
    }

}
