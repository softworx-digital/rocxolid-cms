<?php

namespace Softworx\RocXolid\CMS\Models\Forms\Page;

// rocXolid forms & related
use Softworx\RocXolid\Forms\AbstractCrudUpdateForm;
use Softworx\RocXolid\Forms\Fields\Type as FieldType;

/**
 * Page model extended data update form.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class UpdateExtendedData extends AbstractCrudUpdateForm
{
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
    protected function adjustFieldsDefinition(array $fields): array
    {
        $fields['dependencies']['options']['collection'] = $this->getModel()->getAvailableDependencies()->mapWithKeys(function ($dependency) {
            return [ (new \ReflectionClass($dependency))->getName() => $dependency->getTranslatedTitle($this->getController()) ];
        });

        return $fields;
    }
}
