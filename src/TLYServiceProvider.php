<?php

namespace TLY\LaravelUrlShortener;

use Illuminate\Support\ServiceProvider;

class TLYServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/tly.php' => config_path('tly.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/tly.php', 'tly');

        $this->app->singleton('tlyapi', function ($app) {
            return new TLYApiService(
                config('tly.api_token'),
                config('tly.api_base_url')
            );
        });
    }
}
