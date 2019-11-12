<?php

namespace Softworx\RocXolid\CMS\Models\Forms\CookieConsent;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// fields
use Softworx\RocXolid\Forms\Fields\Type\WysiwygTextarea;
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

    protected function adjustFieldsDefinition($fields)
    {
        $fields['modal_body']['type'] = WysiwygTextarea::class;

        return parent::adjustFieldsDefinition($fields);
    }
}