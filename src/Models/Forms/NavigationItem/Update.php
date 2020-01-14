<?php

namespace Softworx\RocXolid\CMS\Models\Forms\NavigationItem;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type\UploadImage;

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

    protected function adjustFieldsDefinition($fields)
    {
        $fields['image']['type'] = UploadImage::class;
        $fields['image']['options']['multiple'] = false;
        $fields['image']['options']['label']['title'] = 'image';

        return $fields;
    }
}
