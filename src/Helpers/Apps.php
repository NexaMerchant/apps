<?php

namespace NexaMerchant\Apps\Helpers;

use Illuminate\Support\Facades\Route;

// This is a helper class for Apps
class Apps
{
    // This is a helper function for Apps
    public static function routes()
    {
        Route::group([
            'namespace' => 'NexaMerchant\Apps\Http\Controllers',
            'prefix' => 'api',
            'middleware' => 'api',
        ], function () {
            Route::get('apps', 'AppsController@index');
            Route::post('apps', 'AppsController@store');
            Route::get('apps/{id}', 'AppsController@show');
            Route::put('apps/{id}', 'AppsController@update');
            Route::delete('apps/{id}', 'AppsController@destroy');
        });
    }

    
}