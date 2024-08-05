<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Pagination\Paginator
            ::defaultView('vendor.pagination.default');
        \Illuminate\Pagination\Paginator
            ::defaultSimpleView('vendor.pagination.simple-default');
    }
}
