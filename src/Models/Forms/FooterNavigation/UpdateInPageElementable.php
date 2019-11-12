<?php

namespace Softworx\RocXolid\CMS\Models\Forms\FooterNavigation;

// fields
use Softworx\RocXolid\Forms\Fields\Type\UploadImage;
use Softworx\RocXolid\CMS\Models\Forms\AbstractUpdateInPageElementable;

class UpdateInPageElementable extends AbstractUpdateInPageElementable
{
    protected $fields_order = [
        'image',
    ];

    protected function adjustFieldsDefinition($fields)
    {
        $fields['image']['type'] = UploadImage::class;
        $fields['image']['options']['multiple'] = false;
        $fields['image']['options']['label']['title'] = 'image';

        return parent::adjustFieldsDefinition($fields);
    }
}