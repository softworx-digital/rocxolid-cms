<?php

namespace Softworx\RocXolid\CMS\Providers;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
// rocXolid cms services
use Softworx\RocXolid\CMS\Services\ThemeManagerService;

/**
 * rocXolid CMS facades service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
class FacadeServiceProvider extends IlluminateServiceProvider
{
    /**
     * Register rocXolid facades.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    public function register(): IlluminateServiceProvider
    {
        $this->app->singleton('theme.manager', function () {
            return $this->app->make(ThemeManagerService::class);
        });

        return $this;
    }
}
