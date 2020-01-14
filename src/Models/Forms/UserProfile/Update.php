<?php

namespace Softworx\RocXolid\CMS\Models\Forms\UserProfile;

// fields
use Softworx\RocXolid\Forms\Fields\Type\UploadImage;
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;

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
}
