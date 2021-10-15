<?php

namespace Softworx\RocXolid\CMS\Models\Forms\Article;

// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// rocXolid form fields
use Softworx\RocXolid\Forms\Fields\Type as FieldType;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Web;
use Softworx\RocXolid\Common\Models\Localization;
// filters
// use Softworx\RocXolid\Common\Filters\BelongsToWeb;
// use Softworx\RocXolid\Common\Filters\BelongsToLocalization;

/**
 *
 */
class Create extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'store',
        'class' => 'form-horizontal form-label-left',
    ];

    protected $fields = [
        'web_id' => [
            'type' => FieldType\CollectionSelect::class,
            'options' => [
                'label' => [
                    'title' => 'web_id',
                ],
                'attributes' => [
                    'placeholder' => 'select',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],
        'localization_id' => [
            'type' => FieldType\CollectionSelect::class,
            'options' => [
                'label' => [
                    'title' => 'localization_id',
                ],
                'attributes' => [
                    'placeholder' => 'select',
                ],/*
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],*/
            ],
        ],
        'date' => [
            'type' => FieldType\Datepicker::class,
            'options' => [
                'label' => [
                    'title' => 'date',
                ],
                'validation' => [
                    'rules' => [
                        'nullable',
                        'date',
                    ],
                ],
            ],
        ],
        'title' => [
            'type' => FieldType\Input::class,
            'options' => [
                'label' => [
                    'title' => 'title',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'unique:cms_articles,title',
                        'max:100',
                    ],
                ],
            ],
        ],
    ];

    protected function adjustFieldsDefinition(array $fields): array
    {
        $fields['web_id']['options']['collection'] = Web::all()->pluck('name', 'id');
        $fields['web_id']['options']['validation']['rules'][] = 'required';
        $fields['web_id']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());
        //
        // $fields['localization_id']['options']['collection'] = $this->getModel()->detectWeb($this)->localizations->pluck('name', 'id');
        $fields['localization_id']['options']['collection'] = Localization::all()->pluck('name', 'id');
        $fields['localization_id']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());

        return $fields;
    }
}
