<?php

namespace Softworx\RocXolid\CMS\Models\Forms\WebFrontpageSettings;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// filters
use Softworx\RocXolid\Filters\NotMe;
// fields
use Softworx\RocXolid\Forms\Fields\Type\Input,
    Softworx\RocXolid\Forms\Fields\Type\Email,
    Softworx\RocXolid\Forms\Fields\Type\Textarea,
    Softworx\RocXolid\Forms\Fields\Type\ButtonSubmit,
    Softworx\RocXolid\Forms\Fields\Type\ButtonGroup,
    Softworx\RocXolid\Forms\Fields\Type\CollectionSelect,
    Softworx\RocXolid\Forms\Fields\Type\CollectionSelectAutocomplete;
// models
use Softworx\RocXolid\Common\Models\Web;
/**
 *
 */
class CloneStructure extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'cloneStructureSubmit',
        'class' => 'form-horizontal form-label-left',
    ];

    protected $fields = [
        'web_id' => [
            'type' => CollectionSelect::class,
            'options' => [
                'label' => [
                    'title' => 'web_to_clone',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],
    ];

    protected $buttons = [
        // submit - default group
        'submit-ajax' => [
            'type' => ButtonSubmit::class,
            'options' => [
                'group' => ButtonGroup::DEFAULT_NAME,
                'ajax' => true,
                'label' => [
                    'title' => 'clone',
                ],
                'attributes' => [
                    'class' => 'btn btn-success',
                ],
            ],
        ],
    ];

    protected function adjustFieldsDefinition($fields)
    {
        $webs = Web::where('id', '!=', $this->getModel()->id)->pluck('name', 'id');

        // $fields['web_id']['options']['show_null_option'] = true;
        $fields['web_id']['options']['collection'] = $webs;
        $fields['web_id']['options']['validation']['rules'][] = 'required';

        return $fields;
    }
}