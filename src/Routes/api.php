<?php
/**
 * 
 * This file is auto generate by Nicelizhi\Apps\Commands\Create
 * @author Steve
 * @date 2024-07-31 16:40:02
 * @link https://github.com/xxxl4
 * 
 */
use Illuminate\Support\Facades\Route;
use NexaMerchant\Apps\Http\Controllers\Api\ExampleController;
use NexaMerchant\Apps\Http\Controllers\Api\V1\AppsController;

Route::group(['middleware' => ['api'], 'prefix' => 'api'], function () {
     Route::prefix('apps')->group(function () {

        Route::controller(ExampleController::class)->prefix('example')->group(function () {

            Route::get('demo', 'demo')->name('apps.api.example.demo');

        });

     });


        Route::prefix('v1')->group(function () {
    
            Route::controller(AppsController::class)->prefix('apps')->group(function () {
    
                Route::get('demo', 'demo')->name('apps.api.v1.apps.demo');
    
            });
    
        });

        

});