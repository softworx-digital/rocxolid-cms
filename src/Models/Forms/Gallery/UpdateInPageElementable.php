<?php

namespace Softworx\RocXolid\CMS\Models\Forms\Gallery;

// fields
use Softworx\RocXolid\Forms\Fields\Type\UploadImage;
use Softworx\RocXolid\CMS\Models\Forms\AbstractUpdateInPageElementable;

class UpdateInPageElementable extends AbstractUpdateInPageElementable
{
    protected function adjustFieldsDefinition($fields)
    {
        $fields['images']['type'] = UploadImage::class;
        $fields['images']['options']['multiple'] = true;
        $fields['images']['options']['label']['title'] = 'images';
        $fields['images']['options']['image-preview-size'] = 'small-square';

        return parent::adjustFieldsDefinition($fields);
    }
}
