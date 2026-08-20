<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        if (env('APP_ENV') === 'production') {
            // Force root to /kiosk
            URL::forceRootUrl(config('app.url'));
            URL::forceScheme('https');
        } 
    /*  
        if (env('FORCE_HTTPS', false)) {
        URL::forceScheme('https');
    }
        */
    }
}
