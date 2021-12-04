<?php

namespace App\Providers;

use App\Service\ReservationService;
use Illuminate\Support\ServiceProvider;

class ReservationServiceProvider extends ServiceProvider
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
        $this->app->singleton(ReservationService::class, function ($app) {
            return new ReservationService();
        });
    }
}
