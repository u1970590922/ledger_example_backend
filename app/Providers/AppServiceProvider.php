<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected array $bindArray = [
        'App\Services\Auth\Interfaces\GuardServiceInterface' => 'App\Services\Auth\GuardService',
        'App\Services\User\Interfaces\UserServiceInterface' => 'App\Services\User\UserService',
        'App\Services\Finance\Interfaces\LedgerServiceInterface' => 'App\Services\Finance\LedgerService',
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->bindArray as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
