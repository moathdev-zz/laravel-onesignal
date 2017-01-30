<?php

namespace Moathdev\OneSignal;

use GuzzleHttp\Client;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {

        $this->app->bind(OneSignal::class, function (Container $app) {
            return new OneSignal($app->make(Client::class), $app);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $source = realpath(__DIR__ . '/../config/oneSignal.php');

        $this->publishes([$source => config_path('oneSignal.php')]);

        $this->mergeConfigFrom($source, 'oneSignal');


    }
}