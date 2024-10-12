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

                Route::post('publish', 'publish')->name('apps.api.v1.apps.publish');

                Route::post('upload', 'upload')->name('apps.api.v1.apps.upload');

                Route::get('download', 'download')->name('apps.api.v1.apps.download');

                Route::get('list', 'list')->name('apps.api.v1.apps.list');

                Route::get('info', 'info')->name('apps.api.v1.apps.info');

                Route::get('delete', 'delete')->name('apps.api.v1.apps.delete');

                Route::get('install', 'install')->name('apps.api.v1.apps.install');

                Route::get('uninstall', 'uninstall')->name('apps.api.v1.apps.uninstall');

                Route::get('enable', 'enable')->name('apps.api.v1.apps.enable');

                Route::get('disable', 'disable')->name('apps.api.v1.apps.disable');

                Route::get('update', 'update')->name('apps.api.v1.apps.update');

                Route::get('rollback', 'rollback')->name('apps.api.v1.apps.rollback');

                Route::get('status', 'status')->name('apps.api.v1.apps.status');

                Route::get('logs', 'logs')->name('apps.api.v1.apps.logs');

                Route::get('clear', 'clear')->name('apps.api.v1.apps.clear');

                Route::get('config', 'config')->name('apps.api.v1.apps.config');

                Route::get('setting', 'setting')->name('apps.api.v1.apps.setting');

                Route::get('show', 'show')->name('apps.api.v1.apps.show');

                Route::get('type', 'type')->name('apps.api.v1.apps.type');

                Route::get('category', 'category')->name('apps.api.v1.apps.category');
    
            });


    
        });

        

});