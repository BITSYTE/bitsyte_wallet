<?php

namespace App\Providers;

use App\Models\Address;
use App\Models\Wallet;
use App\Policies\AddressPolicy;
use App\Policies\WalletPolicy;
use Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Wallet::class => WalletPolicy::class,
        Address::class => AddressPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('allow-wallet', function($user){
            /** @var \App\Models\User $user */
            return $user->isconfirmed();
        });
    }
}
