<?php

namespace Softworx\RocXolid\CMS\Models\Pivots;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
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
abstract class AbstractElementableElement extends MorphPivot
{
    protected $fillable = [
        'position',
    ];

    abstract public function parent();

    public function setElement(Elementable $container, Element $element)
    {
        $this->parent()->associate($container);
        $this->element()->associate($element);

        return $this;
    }

    public function element()
    {
        return $this->morphTo();
    }

    public function getTable()
    {
        return sprintf('cms_%s_has_elements', Str::snake((new \ReflectionClass($this->parent()->getRelated()))->getShortName()));
    }
}