<?php

namespace Softworx\RocXolid\CMS\Composers;

use Illuminate\Contracts\View\View;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
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
    private static $assignments;

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
        $models = collect();

        if (!isset(self::$assignments)) { // caching
            $dependencies = $element->getDependenciesProvider()->provideDependencies(); // @todo not w/subdependencies?

            $assignments = collect();

            $dependencies->each(function ($elementable_dependency) use (&$assignments, $element) {
                $elementable_dependency->addAssignment($assignments, $element->getDependenciesDataProvider());
            });

            self::$assignments = $assignments;
        }

        self::$assignments->each(function ($value, $key) use (&$view, $models) {
            $view->with($key, $value);

            if ($value instanceof CrudableModel) {
                $models->put($key, $value);
            }
        });

        $view->with('__models', $models);

        return $this;
    }
}
