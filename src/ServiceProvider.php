<?php

namespace Softworx\RocXolid\CMS;

use Illuminate\Foundation\AliasLoader;
// rocXolid service providers
use Softworx\RocXolid\AbstractServiceProvider as RocXolidAbstractServiceProvider;

/**
 * rocXolid CMS package primary service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class ServiceProvider extends RocXolidAbstractServiceProvider
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
        $this->app->register(Providers\FacadeServiceProvider::class);
        $this->app->register(Providers\ExtensionServiceProvider::class);

        $this
            ->bindContracts()
            ->bindAliases(AliasLoader::getInstance());
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
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/rocXolid:cms'), // used by laravel's FileLoaded::loadNamespaceOverrides()
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

    /**
     * Bind contracts / facades, so they don't have to be added to config/app.php.
     *
     * Usage:
     *      $this->app->bind(<SomeContract>::class, <SomeImplementation>::class);
     *
     * @return \Softworx\RocXolid\AbstractServiceProvider
     */
    private function bindContracts(): RocXolidAbstractServiceProvider
    {
        return $this;
    }

    /**
     * Bind aliases, so they don't have to be added to config/app.php.
     *
     * Usage:
     *      $loader->alias('<alias>', <Facade/>Contract>::class);
     *
     * @return \Softworx\RocXolid\AbstractServiceProvider
     */
    private function bindAliases(AliasLoader $loader): RocXolidAbstractServiceProvider
    {
        return $this;
    }
}
