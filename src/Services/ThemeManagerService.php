<?php

namespace Softworx\RocXolid\CMS\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
// rocXolid service contracts
use Softworx\RocXolid\Services\Contracts\ConsumerService;
// rocXolid service traits
use Softworx\RocXolid\Services\Traits\HasServiceConsumer;

/**
 * Service to generate PDF files.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid
 * @version 1.0.0
 */
class ThemeManagerService implements ConsumerService
{
    use HasServiceConsumer;

    public function getThemes(): Collection
    {
        $storage = Storage::disk('themes');

        return collect($storage->directories())->mapWithKeys(function ($theme) {
            return [ $theme => $theme ];
        });
    }
}
