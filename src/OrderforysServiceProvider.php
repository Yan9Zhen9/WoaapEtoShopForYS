<?php

namespace Yan9\Orderforys;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class OrderforysServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $router->aliasMiddleware('orderforys', \Yan9\Orderforys\Middleware\OrderforysMiddleware::class);

        $this->publishes([
            __DIR__.'/Config/orderforys.php' => config_path('orderforys.php'),
        ], 'orderforys_config');

        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');

        $this->loadMigrationsFrom(__DIR__ . '/Migrations');

        $this->loadTranslationsFrom(__DIR__ . '/Translations', 'orderforys');

        $this->publishes([
            __DIR__ . '/Translations' => resource_path('lang/vendor/orderforys'),
        ]);

        $this->loadViewsFrom(__DIR__ . '/Views', 'orderforys');

        $this->publishes([
            __DIR__ . '/Views' => resource_path('views/vendor/orderforys'),
        ]);

        $this->publishes([
            __DIR__ . '/Assets' => public_path('vendor/orderforys'),
        ], 'orderforys_assets');

        if ($this->app->runningInConsole()) {
            $this->commands([
                \Yan9\Orderforys\Commands\OrderforysCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/Config/orderforys.php', 'orderforys'
        );
    }
}
