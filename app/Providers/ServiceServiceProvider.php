<?php

namespace App\Providers;

use App\Interfaces\MemberArea\Services\MemberServiceInterface;
use App\Service\MemberPortal\MemberService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MemberServiceInterface::class, MemberService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
