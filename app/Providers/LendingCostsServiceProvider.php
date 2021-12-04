<?php

namespace App\Providers;

use App\Service\LendingCostsService;
use Illuminate\Support\ServiceProvider;

class LendingCostsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LendingCostsService::class, function ($app) {
            return new LendingCostsService();
        });
    }
}
