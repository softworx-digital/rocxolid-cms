<?php

namespace Softworx\Rocxolid\CMS\Providers;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

/**
 * rocXolid translation service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class TranslationServiceProvider extends IlluminateServiceProvider
{
    /**
     * Bootstrap rocXolid translation services.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    public function boot()
    {
        $this
            ->load();

        return $this;
    }

    /**
     * Load translations.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    private function load()
    {
        // customized translations preference
        $this->loadTranslationsFrom(resource_path('lang/vendor/softworx/rocXolid:cms'), 'rocXolid:cms');

        // pre-defined translations fallback
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'rocXolid:cms');

        return $this;
    }
}
