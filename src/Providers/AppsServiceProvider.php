<?php
/**
 * 
 * This file is auto generate by Nicelizhi\Apps\Commands\Create
 * @author Steve
 * @date 2024-07-31 16:40:02
 * @link https://github.com/xxxl4
 * 
 */
namespace NexaMerchant\Apps\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Webkul\Shop\Http\Middleware\AuthenticateCustomer;
use Webkul\Shop\Http\Middleware\Currency;
use Webkul\Shop\Http\Middleware\Locale;
use Webkul\Shop\Http\Middleware\Theme;

class AppsServiceProvider extends ServiceProvider
{
    private $version = null;
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        Route::middleware('web')->group(__DIR__ . '/../Routes/web.php');
        Route::middleware('api')->group(__DIR__ . '/../Routes/api.php');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'Apps');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'Apps');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        

        /*
        $this->app->register(EventServiceProvider::class);
        */

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../Resources/views' => $this->app->resourcePath('themes/default/views'),
            ], 'Apps');
        }

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands();
        $this->registerConfig();
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/menu.php', 'menu.admin'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/acl.php',
            'acl'
        );

        
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/Apps.php', 'Apps'
        );
        
    }

    /**
     * Register the console commands of this package.
     *
     * @return void
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \NexaMerchant\Apps\Console\Commands\Install::class,
                \NexaMerchant\Apps\Console\Commands\Update::class,
                \NexaMerchant\Apps\Console\Commands\UnInstall::class,
                \NexaMerchant\Apps\Console\Commands\Login::class,
                \NexaMerchant\Apps\Console\Commands\Create::class,
                \NexaMerchant\Apps\Console\Commands\Remove::class,
                \NexaMerchant\Apps\Console\Commands\Lists::class, // apps:lists
                \NexaMerchant\Apps\Console\Commands\Publish::class, // apps:publish
            ]);
        }
    }
}
