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
        $this->publishes([
            __DIR__.'/Config/orderforys.php' => config_path('orderforys.php'),
        ], 'orderforys_config');

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
