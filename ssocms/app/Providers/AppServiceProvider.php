<?php

namespace App\Providers;

use App\Services\Interfaces\SSOServiceInterfaces;
use App\Services\SSOService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SSOServiceInterfaces::class, function () {
            return new SSOService();
        });
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
