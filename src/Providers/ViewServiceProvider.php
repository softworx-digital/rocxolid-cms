<?php

namespace Softworx\RocXolid\CMS\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
// rocXolid cms rendering contracts
use Softworx\RocXolid\CMS\Rendering\Contracts\Themeable;

/**
 * rocXolid views & composers service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class ViewServiceProvider extends IlluminateServiceProvider
{
    /**
     * Bootstrap rocXolid view services.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    public function boot()
    {
        $this
            ->load()
            ->setComposers();

        return $this;
    }

    /**
     * Load views.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    private function load(): IlluminateServiceProvider
    {
        // customized views preference
        $this->loadViewsFrom(resource_path('views/vendor/rocXolid/cms'), 'rocXolid:cms');
        // pre-defined views fallback
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'rocXolid:cms');
        // app themes
        $this->loadViewsFrom(config('rocXolid.cms.themes.path'), Themeable::THEME_PACKAGE);

        return $this;
    }

    /**
     * Set view composers for blade templates.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    private function setComposers(): IlluminateServiceProvider
    {
        foreach (config('rocXolid.cms.general.composers', []) as $view => $composer) {
            View::composer($view, $composer);
        }

        return $this;
    }
}
