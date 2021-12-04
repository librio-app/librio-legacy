<?php

namespace App\Providers;

use App\Service\ShortCutService;
use Illuminate\Support\ServiceProvider;

class ShortCutServiceProvider extends ServiceProvider
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
        $this->app->singleton(ShortCutService::class, function ($app) {
            return new ShortCutService();
        });
    }
}
