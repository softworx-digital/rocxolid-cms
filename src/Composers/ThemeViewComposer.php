<?php

namespace Softworx\RocXolid\CMS\Composers;

use Illuminate\Contracts\View\View;
// rocXolid composer contracts
use Softworx\RocXolid\Composers\Contracts\Composer;

/**
 * View composer for themed views.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class ThemeViewComposer implements Composer
{
    /**
     * {@inheritdoc}
     */
    public function compose(View $view): Composer
    {
        $data = collect($view->getData());
        $element = $data->get('component')->getModel();
        $dependencies = $element->getDependenciesProvider()->provideDependencies();

        $dependencies->each(function ($elementable_dependency) use (&$view, $element) {
            $elementable_dependency->setViewProperties($view, $element->getDependenciesDataProvider());
        });

        return $this;
    }
}
