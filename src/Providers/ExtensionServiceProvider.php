<?php

namespace Softworx\RocXolid\CMS\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
// rocXolid cms rendering services
use Softworx\RocXolid\CMS\Rendering\Services\BladeExtensionService;

/**
 * Blade extensions service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class ExtensionServiceProvider extends IlluminateServiceProvider
{
    /**
     * Extend the default request validator.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    public function boot()
    {
        $this
            ->extendBlade();

        return $this;
    }

    /**
     * Register Blade directives extensions.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    private function extendBlade(): IlluminateServiceProvider
    {
        Blade::directive('editable', function ($args) {
            return BladeExtensionService::compile('editable', $args);
        });

        Blade::directive('elementContent', function ($args) {
            return BladeExtensionService::compile('elementContent', $args);
        });

        Blade::directive('placeholder', function ($args) {
            return BladeExtensionService::compile('placeholder', $args);
        });

        Blade::directive('frontroute', function (string $page_token) {
            // return sprintf("<?php echo isset(\"\$web) ? \"\$web->pageUrl(\"\$localization, $page_token) : '#'")
            return sprintf('<?php echo isset($web) ? $web->pageUrl($localization, %s) : \'#\'; ?>', $page_token);
        });

        return $this;
    }
}
