<?php

namespace Softworx\RocXolid\CMS;

use View;
use Illuminate\Routing\Router;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
//
use Softworx\RocXolid\CrudRouter;
/**
 *
 */
class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(Providers\ConfigurationServiceProvider::class);
        $this->app->register(Providers\ViewServiceProvider::class);
        $this->app->register(Providers\RouteServiceProvider::class);
        $this->app->register(Providers\TranslationServiceProvider::class);
    }

     /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this
            ->publish();
    }

    /**
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    private function publish()
    {
        // customizable config
        $this->publishes([
            __DIR__ . '/../config/customizable.php' => config_path('rocXolid/cms.php'),
            // ...
        ], 'config');

        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('vendor/rocXolid'),
        ], 'public');

        return $this;
    }
}