<?php

namespace Softworx\RocXolid\CMS\Models\Traits;

// rocXolid cms model contracts
use Softworx\RocXolid\CMS\Models\Contracts\ElementsMutatorsProvider;
// rocXolid cms support
use Softworx\RocXolid\CMS\Support\PlaceholderMutatorProvider;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;

/**
 * Elementable mutators provider getter and setter.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
trait HasElementsMutatorsProvider
{
    /**
     * Mutators provider reference.
     *
     * @var \Softworx\RocXolid\CMS\Models\Contracts\ElementsMutatorsProvider
     */
    protected $mutators_provider;

    /**
     * Set mutators provider.
     *
     * @param \Softworx\RocXolid\CMS\Models\Contracts\ElementsMutatorsProvider
     * @return \Softworx\RocXolid\CMS\Elements\Models\Contracts\Element
     */
    public function setMutatorsProvider(ElementsMutatorsProvider $mutators_provider): Element
    {
        $this->mutators_provider = $mutators_provider;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getMutatorsProvider(): ElementsMutatorsProvider
    {
        return $this->mutators_provider ?? $this->getDefaultMutatorsProvider();
    }

    /**
     * Obtain default mutators provider.
     *
     * @return \Softworx\RocXolid\CMS\Models\Contracts\ElementsMutatorsProvider
     */
    public function getDefaultMutatorsProvider(): ElementsMutatorsProvider
    {
        return app(PlaceholderMutatorProvider::class);
    }
}
