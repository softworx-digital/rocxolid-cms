<?php

namespace Softworx\RocXolid\CMS\Models\Forms;

use Softworx\RocXolid\CMS\Models\Forms\AbstractInPageElementable;

abstract class AbstractCreateInPageElementable extends AbstractInPageElementable
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'store',
        'class' => 'form-horizontal form-label-left',
        'section' => 'page-elements',
    ];
}
