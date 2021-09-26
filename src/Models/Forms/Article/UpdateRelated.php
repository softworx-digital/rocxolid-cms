<?php

namespace Softworx\RocXolid\CMS\Models\Forms\Article;

use Illuminate\Database\Eloquent\Builder;
// rocXolid forms & fields
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type as FieldType;

/**
 * Article related data update form.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class UpdateRelated extends RocXolidAbstractCrudForm
{
    /**
     * {@inheritDoc}
     */
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
        'section' => 'related-data',
    ];

    /**
     * {@inheritDoc}
     */
    protected $fields = [
        'related' => [
            'type' => FieldType\CollectionCheckbox::class,
            'options' => [
                'type-template' => 'collection-checkbox-buttons-new',
                'label' => null,
                'validation' => [
                    'rules' => [
                        'exists:cms_articles,id',
                    ],
                ],
                'attributes' => [
                    'placeholder' => 'select',
                ],
            ],
        ],
    ];

    protected $buttons = [
        // submit - default group
        'submit' => [
            'type' => FieldType\ButtonSubmit::class,
            'options' => [
                'ajax' => true,
                'group' => FieldType\ButtonGroup::DEFAULT_NAME,
                'label' => [
                    'title' => 'save',
                ],
                'attributes' => [
                    'class' => 'btn btn-success'
                ],
            ],
        ],
    ];

    /**
     * {@inheritDoc}
     */
    protected function adjustFieldsDefinition($fields)
    {
        $fields['related']['options']['collection'] = $this->getModel()->query()
            ->where($this->getModel()->getKeyName(), '!=', $this->getModel()->getKey())
            ->where(function (Builder $query) {
                return $query
                    ->where('localization_id', optional($this->getModel()->localization)->getKey())
                    ->orWhereNull('localization_id');
            })
            ->get();

        return $fields;
    }
}
