<?php

namespace Softworx\RocXolid\CMS\Models\Forms\Gallery;

// fields
use Softworx\RocXolid\Forms\Fields\Type\UploadImage;
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;

class Update extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
    ];

    protected function adjustFieldsDefinition($fields)
    {
        $fields['images']['type'] = UploadImage::class;
        $fields['images']['options']['multiple'] = true;
        $fields['images']['options']['label']['title'] = 'images';
        $fields['images']['options']['image-preview-size'] = 'small-square';

        return $fields;
    }
}
