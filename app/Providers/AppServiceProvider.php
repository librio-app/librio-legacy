<?php

namespace App\Providers;

use App\Models\Member\Book;
use App\Observers\StatusObserver;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // fix carbon name
        Carbon::setLocale(substr(config('app.locale'), 0, 2));

        // force https
        if(config('app.env') === 'production') {
            \URL::forceScheme('https');
        }

        // observers
        Book::observe(StatusObserver::class);

        // default use bootstrap
        Paginator::useBootstrap();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
