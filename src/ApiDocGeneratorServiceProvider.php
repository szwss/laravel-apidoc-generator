<?php

namespace Szwss\ApiDoc;

use Illuminate\Support\ServiceProvider;
use Szwss\ApiDoc\Commands\UpdateDocumentation;
use Szwss\ApiDoc\Commands\GenerateDocumentation;

class ApiDocGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'apidoc');

        $this->publishes([
            __DIR__.'/../resources/views' => app()->basePath().'/resources/views/vendor/apidoc',
        ], 'views');

        $this->publishes([
            __DIR__.'/../config/apidoc.php' => app()->basePath().'/config/apidoc.php',
        ], 'config');

        $this->mergeConfigFrom(__DIR__.'/../config/apidoc.php', 'apidoc');

        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateDocumentation::class,
                UpdateDocumentation::class,
            ]);
        }
    }

    /**
     * Register the API doc commands.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
