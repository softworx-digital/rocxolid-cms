<?php

namespace Softworx\RocXolid\CMS\Support;

use Illuminate\Http\Request;
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
class RequestElementableDependencyDataProvider implements ElementableDependencyDataProvider
{
    /**
     * Undocumented variable
     *
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * Constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
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
        return collect();
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
