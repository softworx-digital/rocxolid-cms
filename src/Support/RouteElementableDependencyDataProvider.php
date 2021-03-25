<?php

namespace Softworx\RocXolid\CMS\Support;

use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
// rocXolid cms models contracts
use Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProvider;
// rocXolid cms elementable dependency contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider;

/**
 * Extracts dependency data from request.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class RouteElementableDependencyDataProvider implements ElementableDependencyDataProvider
{
    /**
     * Route reference.
     *
     * @var \Illuminate\Routing\Route
     */
    private $route;

    /**
     * Constructor.
     *
     * @param \Illuminate\Routing\Route $route
     */
    public function __construct(Route $route)
    {
        $this->route = $route;
    }

    /**
     * {@inheritDoc}
     */
    public function setDependencyData(ElementsDependenciesProvider $document, Collection $data): ElementableDependencyDataProvider
    {
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getDependencyData(): Collection
    {
        return collect($this->route->parameters());
    }

    /**
     * {@inheritDoc}
     */
    public function getDependencies(array $except = []): Collection
    {
        return collect();
    }

    /**
     * Check if the data provider is ready (has set dependency values).
     *
     * @return bool
     */
    public function isReady(): bool
    {
        return true;
    }
}
