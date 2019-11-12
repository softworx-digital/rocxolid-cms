<?php

namespace Softworx\RocXolid\CMS\Models\Forms;

use Softworx\RocXolid\CMS\Models\Forms\AbstractInPageElementable;

abstract class AbstractUpdateInPageElementable extends AbstractInPageElementable
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
        'section' => 'page-elements',
    ];
}