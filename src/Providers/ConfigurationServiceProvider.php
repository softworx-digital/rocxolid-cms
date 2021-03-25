<?php

namespace Softworx\RocXolid\CMS\Providers;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

/**
 * rocXolid configuration service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class ConfigurationServiceProvider extends IlluminateServiceProvider
{
    /**
     * @var array $config_files Configuration files to be published and loaded.
     */
    protected $config_files = [
        'rocXolid.cms.general' => '/../../config/general.php',
        'rocXolid.cms.themes' => '/../../config/themes.php',
        'rocXolid.cms.elementable' => '/../../config/elementable.php',
    ];

    /**
     * Register configuration provider for rocXolid CMS package.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    public function register(): IlluminateServiceProvider
    {
        $this
            ->configure();

        return $this;
    }

    /**
     * Extend the filesystem to provide easy access with Storage facade.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    public function boot()
    {
        $this->app->config['filesystems.disks.themes'] = [
            'driver' => 'local',
            'root' => config('rocXolid.cms.themes.path'),
        ];

        return $this;
    }

    /**
     * Set configuration files for loading.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    private function configure(): IlluminateServiceProvider
    {
        foreach ($this->config_files as $key => $path) {
            $path = realpath(__DIR__ . $path);

            if (file_exists($path)) {
                $this->mergeConfigFrom($path, $key);
            }
        }

        return $this;
    }
}
