<?php

namespace Softworx\RocXolid\CMS\Models\Forms\WebFrontpageSettings;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// fields
use Softworx\RocXolid\Forms\Fields\Type\Select;

class Create extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'store',
        'class' => 'form-horizontal form-label-left',
    ];

    protected function adjustFieldsDefinition($fields)
    {
        $fields['template_set']['type'] = Select::class;
        $fields['template_set']['options']['placeholder']['title'] = 'template_set';
        $fields['template_set']['options']['choices'] = $this->getModel()->getTemplateSetsOptions();

        return $fields;
    }
}
