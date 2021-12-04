<?php

namespace App\Providers;

use App\Models\Member\Book;
use App\Observers\StatusObserver;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rule;

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
