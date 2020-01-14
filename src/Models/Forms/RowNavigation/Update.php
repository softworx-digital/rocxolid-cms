<?php

namespace Softworx\RocXolid\CMS\Models\Forms\RowNavigation;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// fields
use Softworx\RocXolid\Forms\Fields\Type\Select;

/**
 *
 */
class Update extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
    ];

    /*
    protected function adjustFieldsDefinition($fields)
    {
        $fields['default_template']['type'] = Select::class;
        $fields['default_template']['options']['placeholder']['title'] = 'default_template';
        $fields['default_template']['options']['choices'] = $this->getModel()->getTemplateOptions();
        $fields['default_template']['options']['validation']['rules'][] = 'required';

        return $fields;
    }
    */
}
