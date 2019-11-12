<?php

namespace Softworx\RocXolid\CMS\Models\Forms\Gallery;

// fields
use Softworx\RocXolid\Forms\Fields\Type\ButtonSubmit,
    Softworx\RocXolid\Forms\Fields\Type\ButtonGroup;
// cms forms
use Softworx\RocXolid\CMS\Models\Forms\AbstractInPageElementable;
/**
 *
 */
class ClearInPageElementable extends AbstractInPageElementable
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'clear',
        'class' => 'form-horizontal form-label-left',
    ];

    protected $buttons = [
        // submit - default group
        'submit-ajax' => [
            'type' => ButtonSubmit::class,
            'options' => [
                'group' => ButtonGroup::DEFAULT_NAME,
                'ajax' => true,
                'label' => [
                    'title' => 'clear',
                ],
                'attributes' => [
                    'class' => 'btn btn-success',
                ],
            ],
        ],
    ];

    protected function adjustFieldsDefinition($fields)
    {
        $fields = parent::adjustFieldsDefinition($fields);

        unset($fields['web_id']);
        unset($fields['name']);

        return $fields;
    }
}