<?php

namespace Softworx\RocXolid\CMS\Models\Forms\Page;

// rocXolid forms & fields
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type as FieldType;

/**
 * Extended data update form.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class UpdateExtended extends RocXolidAbstractCrudForm
{
    /**
     * {@inheritDoc}
     */
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
        'section' => 'extended-data',
    ];

    /**
     * {@inheritDoc}
     */
    protected $fields = [
        'dependencies' => [
            'type' => FieldType\CollectionSelect::class,
            'options' => [
                'label' => [
                    'title' => 'dependencies',
                ],
                'attributes' => [
                    'placeholder' => 'select',
                ],
            ],
        ],
    ];

    /**
     * {@inheritDoc}
     */
    protected function adjustFieldsDefinition($fields)
    {
        $fields['dependencies']['options']['collection'] = $this->getModel()->getAvailableDependencies()->mapWithKeys(function ($dependency) {
            return [ (new \ReflectionClass($dependency))->getName() => $dependency->getTranslatedTitle($this->getController()) ];
        });

        return $fields;
    }
}
