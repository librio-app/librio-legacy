<?php

namespace App\Providers;

use App\Service\BarcodeService;
use Illuminate\Support\ServiceProvider;

class BarcodeServiceProvider extends ServiceProvider
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
        $this->app->singleton(BarcodeService::class, function ($app) {
            return new BarcodeService(setting('barcode'));
        });
    }
}
