<?php

namespace Softworx\RocXolid\CMS\Composers;

use Illuminate\Contracts\View\View;
// rocXolid composer contracts
use Softworx\RocXolid\Composers\Contracts\Composer;
// rocXolid cms model contracts
use Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProviderable;

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

        $this->setViewPropertiesFromDependencies($view, $element);

        return $this;
    }

    /**
     * Set the view properties from what is obtained by element dependencies.
     *
     * @param \Illuminate\Contracts\View\View $view
     * @param \Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProviderable $element
     * @return \Softworx\RocXolid\Composers\Contracts\Composer
     */
    protected function setViewPropertiesFromDependencies(View &$view, ElementsDependenciesProviderable $element): Composer
    {
        $dependencies = $element->getDependenciesProvider()->provideDependencies(); // @todo: not w/subdependencies?

        $assignments = collect();

        $dependencies->each(function ($elementable_dependency) use (&$assignments, $element) {
            $elementable_dependency->addAssignment($assignments, $element->getDependenciesDataProvider());
        });

        $assignments->each(function ($value, $key) use (&$view) {
            $view->with($key, $value);
        });

        return $this;
    }
}
