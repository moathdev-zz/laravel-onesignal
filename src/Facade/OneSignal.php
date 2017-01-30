<?php

namespace Moathdev\OneSignal\Facade;

use Illuminate\Support\Facades\Facade;

class OneSignal extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Moathdev\OneSignal\OneSignal::class;
    }
}