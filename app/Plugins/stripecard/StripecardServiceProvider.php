<?php

namespace App\Plugins\stripecard;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Route;

class StripecardServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // Load plugin views
        $this->loadViewsFrom(realpath(__DIR__ . '/resources/views'), 'payment');

        // Load plugin languages files
        $this->loadTranslationsFrom(realpath(__DIR__ . '/resources/lang'), 'stripecard');

        // Merge plugin config
        $this->mergeConfigFrom(realpath(__DIR__ . '/config.php'), 'payment');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('stripecard', function ($app) {
            return new Stripecard($app);
        });
    }
}
