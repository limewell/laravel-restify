<?php

namespace Limewell\LaravelRestify;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Limewell\LaravelRestify\Console\Commands\{GenerateRestify,
    InstallRestify,
    MakeRestifyCollectionCommand,
    MakeRestifyControllerCommand,
    MakeRestifyRequestCommand,
    MakeRestifyResourceCommand
};
use Limewell\LaravelRestify\Http\Middleware\AddHeadersToApiRequest;

class LaravelRestifyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     * @throws BindingResolutionException
     */
    public function boot()
    {
        /*Register Middleware*/
        $router = $this->app->make(Router::class);
        $router->prependMiddlewareToGroup('api', AddHeadersToApiRequest::class);
        /*Register Middleware*/

        /*
         * Optional methods to load your package assets
         */
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'laravel-restify');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-restify');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->registerRoutes();

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('laravel-restify.php'),
            ], 'config');

            // Publishing the views.
            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/laravel-restify'),
            ], 'views');

            // Publishing assets.
            $this->publishes([
                __DIR__ . '/../resources/assets' => public_path('vendor/laravel-restify'),
            ], 'assets');

            // Publishing the translation files.
            $this->publishes([
                __DIR__ . '/../resources/lang' => resource_path('lang/vendor/laravel-restify'),
            ], 'lang');

            // Publishing the stub files.
            $this->publishes([
                __DIR__ . '/../stubs' => base_path('stubs/vendor/laravel-restify'),
            ], 'stubs');

            // Registering package commands.
            $this->commands([
                InstallRestify::class,
                GenerateRestify::class,
                MakeRestifyRequestCommand::class,
                MakeRestifyControllerCommand::class,
                MakeRestifyResourceCommand::class,
                MakeRestifyCollectionCommand::class,
            ]);
        }
    }

    /**
     *
     */
    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }

    /**
     * @return array
     */
    protected function routeConfiguration(): array
    {
        return [
            'prefix' => config('laravel-restify.prefix'),
            'middleware' => config('laravel-restify.middleware'),
        ];
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'laravel-restify');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-restify', function () {
            return new LaravelRestify;
        });
    }
}
