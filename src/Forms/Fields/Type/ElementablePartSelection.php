<?php

namespace Softworx\RocXolid\CMS\Forms\Fields\Type;

// rocXolid contracts
use Softworx\RocXolid\Contracts\Valueable;
// rocXolid form fields
use Softworx\RocXolid\Forms\Fields\Type\CollectionRadioList;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\Permission;

class ElementablePartSelection extends CollectionRadioList
{
    protected $part_relation_name;

    protected $default_options = [
        'view-package' => 'rocXolid:cms',
        'template' => 'elementable-part-selection.default',
        'collection-item-template' => 'include.elements',
        // field wrapper
        'wrapper' => [
            'attributes' => [
                // 'class' => 'well well-sm bg-info',
            ],
        ],
        // field label
        'label' => false,
        // field HTML attributes
        'attributes' => [
        ],
    ];

    public function setPart(string $relation_name)
    {
        return $this->part_relation_name = $relation_name;
    }

    public function getPartModel()
    {
        return $this->getForm()->getModel()->{$this->part_relation_name}()->getRelated();
    }

    public function hasPartModel()
    {
        return $this->getForm()->getModel()->{$this->part_relation_name}()->exists();
    }

    public function getPartModelComponent()
    {
        return $this->getPartModel()->getModelViewerComponent();
    }
}
