<?php

namespace App\Providers;

use GeoIp2\Database\Reader;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class CookieConsentProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        View::composer('common.cookie-consent', function($view) {

            $reader = new Reader( dirname(__FILE__) . '/GeoIP2-Country/GeoLite2-Country.mmdb');
            // $record = $reader->country('128.101.101.101'); //Request::server('REMOTE_ADDR'));
            $record = $reader->country(Request::server('REMOTE_ADDR'));
            $countryArray = array();
            $countryArray['code'] = $record->country->isoCode;
            $countryArray['name'] = $record->country->name;
            $countryArray['iseu'] = $record->country->isInEuropeanUnion;
            $countryArray['domain'] = Request::server('SERVER_NAME');
            $view->with('countryRecord', $countryArray);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
