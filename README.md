## Laravel 5.2 OneSignal

A Onesignal package for Laravel 5.2 or higher
 
##Installation

````
composer require moathdev/laravel-onesignal
````
After install this package you have to set the service provider on your config/app.php file

````
Moathdev\OneSignal\ServiceProvider::class,
````

To use the facade add this to the facades in app/config/app.php
````
'OneSignal' => \Moathdev\OneSignal\Facade\OneSignal::class
````
Then you just need to publish files ! Copy and paste it

````
php artisan vendor:publish --provider="Moathdev\OneSignal\ServiceProvider"
````


Setting up your OneSignal account on your  **Environment** file

````
ONESIGNAL_APP_ID=759xxxxxxx

ONESIGNAL_API_KEY=MjYzxxxxxx

- User Auth Key -
ONESIGNAL_USER_AUTH_KEY=ZMOADxxxxxx

````
##Example Usage
````
use Moathdev\OneSignal\Exceptions\FailedToSendNotificationException;
use Moathdev\OneSignal\Facade\OneSignal;


Route::get('/', function () {
    try {

        $res = OneSignal::SendNotificationToAll('Hello', 'World');

    } catch (FailedToSendNotificationException $e) {

        dd($e);
    }
    dd($res);
});
 ````
Methods supported by this package and their parameters can be found in the [API Reference](https://documentation.onesignal.com/reference) 
##Issues

````

If you have any questions or issues, please open an Issue .
