<?php

namespace Softworx\RocXolid\CMS\Composers;

use Illuminate\Contracts\View\View;
// rocXolid composer contracts
use Softworx\RocXolid\Composers\Contracts\Composer;

class ThemeViewComposer implements Composer
{
    /**
     * {@inheritdoc}
     */
    public function compose(View $view): Composer
    {
        $data = collect($view->getData());

        $view
            ->with('element_data_provider', $data->get('element_data_provider', $data->get('component')));

        return $this;
    }
}
