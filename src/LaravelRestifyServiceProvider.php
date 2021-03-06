<?php

namespace Limewell\LaravelRestify;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Routing\BindingRegistrar;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Router;
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
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'restify');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'restify');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->registerRoutes();
        $this->registerMacros();

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('restify.php'),
            ], 'config');

            // Publishing the views.
            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/restify'),
            ], 'views');

            // Publishing assets.
            $this->publishes([
                __DIR__ . '/../resources/assets' => public_path('vendor/restify'),
            ], 'assets');

            // Publishing the translation files.
            $this->publishes([
                __DIR__ . '/../resources/lang' => resource_path('lang/vendor/restify'),
            ], 'lang');

            // Publishing the stub files.
            $this->publishes([
                __DIR__ . '/../stubs' => base_path('stubs/vendor/restify'),
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
     * @throws BindingResolutionException
     */
    protected function registerMacros()
    {
        $response = $this->app->make(ResponseFactory::class);
        if (!$response->hasMacro('restifyJson')) {
            $response->macro('restifyJson', function (array $args, int $status = 200) use ($response): JsonResponse {
                extract($args);
                return $response->json([
                    'data' => $data ?? [],
                    'success' => $success ?? true,
                    'message' => $message ?? null,
                    'meta' => $meta ?? null,
                    'errors' => $errors ?? null,
                ], $status);
            });
        }
    }

    /**
     * @throws BindingResolutionException
     */
    protected function registerRoutes()
    {
        $route = $this->app->make(BindingRegistrar::class);
        $route->group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }

    /**
     * @return array
     */
    protected function routeConfiguration(): array
    {
        return [
            'prefix' => config('restify.prefix'),
            'middleware' => config('restify.middleware'),
        ];
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'restify');

        // Register the main class to use with the facade
        $this->app->singleton('restify', function () {
            return new LaravelRestify;
        });
    }
}
