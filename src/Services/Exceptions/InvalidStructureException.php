<?php

namespace Softworx\RocXolid\CMS\Services\Exceptions;

use Illuminate\Support\Collection;
// rocXolid exceptions
use Softworx\RocXolid\Exceptions\Exception;
// rocXolid cms model elements contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable;
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;

/**
 * Serves to be passed to a "not-found" view.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid
 * @version 1.0.0
 */
class InvalidStructureException extends Exception
{
    /**
     * @var \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable
     */
    protected $parent_element;

    /**
     * @var \Softworx\RocXolid\CMS\Elements\Models\Contracts\Element
     */
    protected $element;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $element_data;

    public function __construct(Elementable $parent_element, Element $element, Collection $element_data)
    {
        $this->parent_element = $parent_element;
        $this->element = $element;
        $this->element_data = $element_data;

        $this->message = sprintf(
            "Invalid document structure provided!\nElement\n[%s]\ncannot contain child elements.\nElement children data:\n%s",
            get_class($element),
            collect($element_data->get('children'))->toJson()
        );
    }

    /**
     * Parent element getter.
     *
     * @return \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable
     */
    public function getParentElement(): Elementable
    {
        return $this->view_name;
    }

    /**
     * Element getter.
     *
     * @return \Softworx\RocXolid\CMS\Elements\Models\Contracts\Element
     */
    public function getElement(): Element
    {
        return $this->component;
    }

    /**
     * Element data getter.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getElementData(): Collection
    {
        return $this->element_data;
    }
}
