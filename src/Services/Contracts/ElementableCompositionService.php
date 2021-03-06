<?php

namespace Softworx\RocXolid\CMS\Services\Contracts;

use Illuminate\Support\Collection;
// rocXolid service contracts
use Softworx\RocXolid\Services\Contracts\ConsumerService;
// rocXolid cms model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable;

/**
 * Service to handle elementable (page, document,...) composition.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
interface ElementableCompositionService extends ConsumerService
{
    /**
     * Compose elementable with provided structure of elements and persist.
     *
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable $model
     * @param \Illuminate\Support\Collection $structure
     * @return \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable
     */
    public function compose(Elementable $model, Collection $structure): Elementable;

    /**
     * Compose elementable with provided structure of elements for preview - do not persist.
     *
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable $model
     * @param \Illuminate\Support\Collection $structure
     * @return \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable
     */
    public function composePreview(Elementable $model, Collection $structure): Elementable;

    /**
     * Remove given element and underlying structure from composition.
     *
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable $model
     * @param \Illuminate\Support\Collection $data
     * @return \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable
     */
    public function destroyElement(Elementable $model, Collection $data): Elementable;
}
