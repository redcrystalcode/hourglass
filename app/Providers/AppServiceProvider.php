<?php

namespace Hourglass\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;
use Jenssegers\Rollbar\RollbarServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(IdeHelperServiceProvider::class);
        } elseif ($this->app->environment('production')) {
            $this->app->register(RollbarServiceProvider::class);
        }
    }
}
