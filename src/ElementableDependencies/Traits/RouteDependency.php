<?php

namespace Softworx\RocXolid\CMS\ElementableDependencies\Traits;

use Illuminate\Support\Collection;
// rocXolid cms elements models contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable;
// rocXolid cms elementable dependency contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependency;
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider;

/**
 *
 */
trait RouteDependency
{
    public function addRoutePathParameter(Elementable $elementable): Elementable
    {
        $elementable->route_path .= sprintf('/{%s}/{slug}', $this->getAssignmentDefaultName());

        return $elementable;
    }

    /**
     * {@inheritDoc}
     */
    public function getDependencyViewValue(ElementableDependencyDataProvider $dependency_data_provider)
    {
        return __METHOD__;
        /*
        return $this->transformDependencyValue(
            $dependency_data_provider,
            $this->getAssignmentDefaultName(),
            $dependency_data_provider->getDependencyData()->get('xyz')
        );
        */
    }

    /**
     * {@inheritDoc}
     */
    public function addAssignment(Collection &$assignments, ElementableDependencyDataProvider $dependency_data_provider, ?string $key = null): ElementableDependency
    {
        if ($dependency_data_provider->isReady()) {
            $assignments = $assignments->merge($dependency_data_provider->getDependencyData());
        }

        return $this;
    }
}
