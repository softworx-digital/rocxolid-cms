<?php

namespace Softworx\RocXolid\CMS\Models\Forms\RowNavigation;

use Softworx\RocXolid\CMS\Models\Forms\AbstractUpdateInPageElementable;
// fields
use Softworx\RocXolid\Forms\Fields\Type\Select;
/**
 *
 */
class UpdateInPageElementable extends AbstractUpdateInPageElementable
{
    /*
    protected function adjustFieldsDefinition($fields)
    {
        $fields['default_template']['type'] = Select::class;
        $fields['default_template']['options']['placeholder']['title'] = 'default_template';
        $fields['default_template']['options']['choices'] = $this->getModel()->getTemplateOptions();
        $fields['default_template']['options']['validation']['rules'][] = 'required';

        return parent::adjustFieldsDefinition($fields);
    }
    */
}