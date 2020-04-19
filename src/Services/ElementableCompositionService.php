<?php

namespace Softworx\RocXolid\CMS\Services;

use Illuminate\Support\Collection;
// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid service contracts
use Softworx\RocXolid\Services\Contracts\ServiceConsumer;
// rocXolid service traits
use Softworx\RocXolid\Services\Traits\HasServiceConsumer;
// rocXolid cms service contracts
use Softworx\RocXolid\CMS\Services\Contracts\ElementableCompositionService as ElementableCompositionServiceContract;
// rocXolid cms controllers
use Softworx\RocXolid\CMS\Http\Controllers\AbstractElementableController;
// rocXolid cms model contracts
use Softworx\RocXolid\CMS\Models\Contracts\Elementable;

/**
 * Service to handle elementable composition.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class ElementableCompositionService implements ElementableCompositionServiceContract
{
    use HasServiceConsumer;

    /**
     * {@inheritDoc}
     */
    public function compose(CrudRequest $request, Elementable $model): Elementable
    {
        dd($request->all());


        return $model;
    }

    /**
     * {@inheritDoc}
     */
    protected function validateServiceConsumer(ServiceConsumer $consumer): bool
    {
        return ($consumer instanceof AbstractElementableController);
    }
}
