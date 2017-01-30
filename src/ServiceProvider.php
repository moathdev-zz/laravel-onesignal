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
        $this->publishes([
            __DIR__ . '/../config/oneSignal-moath.php' => $this->app('config')->get('oneSignal-moath.php'),
        ], 'config');

        $this->mergeConfigFrom(__DIR__ . '/../config/oneSignal-moath.php', 'oneSignal-moath');

        $this->app->bind(OneSignal::class, function (Container $app){
            return new OneSignal($app->make(Client::class), $app);
        });
    }
}