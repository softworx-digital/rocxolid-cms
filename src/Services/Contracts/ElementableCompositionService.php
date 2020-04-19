<?php

namespace Softworx\RocXolid\CMS\Services\Contracts;

// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid service contracts
use Softworx\RocXolid\Services\Contracts\ConsumerService;
// rocXolid cms model contracts
use Softworx\RocXolid\CMS\Models\Contracts\Elementable;

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
     * Compose elementable with provided structure of elements.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\CMS\Models\Contracts\Elementable $model
     * @return \Softworx\RocXolid\CMS\Models\Contracts\Elementable
     */
    public function compose(CrudRequest $request, Elementable $model): Elementable;
}
