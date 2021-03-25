<?php

namespace Softworx\RocXolid\CMS\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
// rocXolid service contracts
use Softworx\RocXolid\Services\Contracts\ConsumerService;
// rocXolid service traits
use Softworx\RocXolid\Services\Traits\HasServiceConsumer;
// rocXolid cms contracts
use Softworx\RocXolid\CMS\Rendering\Contracts\Themeable;

/**
 * Service to manage CMS themes.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class ThemeManagerService implements ConsumerService
{
    use HasServiceConsumer;

    /**
     * Obtain available themes from directory structure.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getThemes(): Collection
    {
        $storage = Storage::disk('themes');

        return collect($storage->directories())->mapWithKeys(function ($theme) {
            return [ $theme => $theme ];
        });
    }

    /**
     * Obtain available templates for given component.
     *
     * @param string $theme
     * @param Themeable $component
     * @return \Illuminate\Support\Collection
     */
    public function getComponentTemplates(string $theme, Themeable $component): Collection
    {
        $component->setViewTheme($theme);

        $path = Str::after($component->getViewPath(), '::');
        $path = str_replace('.', DIRECTORY_SEPARATOR, $path);
        $path = dirname($path);

        return collect(Storage::disk('themes')->files($path))->transform(function ($blade_path) {
            return basename($blade_path, '.blade.php');
        });
    }
}
