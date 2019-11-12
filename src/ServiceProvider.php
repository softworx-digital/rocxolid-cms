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
        // config files
        // php artisan vendor:publish --provider="Softworx\RocXolid\CMS\ServiceProvider" --tag="config" (--force to overwrite)
        $this->publishes([
            __DIR__ . '/../config/general.php' => config_path('rocXolid/cms/general.php'),
        ], 'config');

        // lang files
        // php artisan vendor:publish --provider="Softworx\RocXolid\CMS\ServiceProvider" --tag="lang" (--force to overwrite)
        $this->publishes([
            //__DIR__ . '/../resources/lang' => resource_path('lang/vendor/softworx/rocXolid/cms'),
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/rocXolid:cms'),
        ], 'lang');

        // views files
        // php artisan vendor:publish --provider="Softworx\RocXolid\CMS\ServiceProvider" --tag="views" (--force to overwrite)
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/softworx/rocXolid/cms'),
        ], 'views');

        // migrations
        // php artisan vendor:publish --provider="Softworx\RocXolid\CMS\ServiceProvider" --tag="migrations" (--force to overwrite)
        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');

        // db dumps
        // php artisan vendor:publish --provider="Softworx\RocXolid\CMS\ServiceProvider" --tag="dumps" (--force to overwrite)
        $this->publishes([
            __DIR__.'/../database/dumps/' => database_path('dumps/rocXolid/cms')
        ], 'dumps');

        return $this;
    }
}