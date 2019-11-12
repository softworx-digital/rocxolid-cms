<?php

namespace Softworx\RocXolid\CMS\Http\Controllers;

use Softworx\RocXolid\CMS\Components\Dashboard\Main as MainDashboard;

class Controller extends AbstractController
{
    public function index()
    {
        return (new MainDashboard($this))->render();
    }
}