<?php

namespace Softworx\RocXolid\CMS\Models\Forms\MainSlider;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;

class Create extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'store',
        'class' => 'form-horizontal form-label-left',
    ];
}
