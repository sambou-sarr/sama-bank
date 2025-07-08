<?php

namespace App\Providers;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
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
        Schema::defaultStringLength(191);
        Paginator::useBootstrap(); 

        if(env('APP_ENV') === 'local'){ 
             URL::forceScheme('https');
        }
    }


}
