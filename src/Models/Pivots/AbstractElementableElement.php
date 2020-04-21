<?php

namespace Softworx\RocXolid\CMS\Models\Pivots;

// rocXolid cms elements model pivots
use Softworx\RocXolid\CMS\Elements\Models\Pivots\AbstractElementableElementPivot;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable;
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;

/**
 * Cross model abstraction to connect elementable with morphed elements.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
abstract class AbstractElementableElement extends AbstractElementableElementPivot
{
    /**
     * {@inheritDoc}
     */
    public function getPrimaryKeyWhereCondition(?Elementable $parent = null, ?Element $element = null): array
    {
        $parent = $parent ?? $this->parent ?? $this->parent()->getRelated();
        $element = $element ?? $this->element ?? $this->element()->getRelated();

        return [
            $this->parent()->getForeignKeyName() => $parent->getKey(),
            $this->element()->getMorphType() => get_class($element),
            $this->element()->getForeignKeyName() => $element->getKey(),
        ];
    }
}