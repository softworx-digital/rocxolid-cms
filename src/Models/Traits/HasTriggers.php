<?php

namespace Softworx\RocXolid\CMS\Models\Traits;

use Illuminate\Support\Collection;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;

/**
 * Trait for triggerable elementable.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
trait HasTriggers
{
    /**
     * {@inheritDoc}
     */
    public function fillTriggers(Collection $data): Crudable
    {
        if ($data->has('triggers')) {
            $this->triggers = json_encode($data->get('triggers'));
        }

        return $this;
    }

    /**
     * Triggers attribute getter mutator.
     *
     * @param mixed $value
     * @return \Illuminate\Support\Collection
     */
    public function getTriggersAttribute($value): Collection
    {
        return collect($value ? json_decode($value) : [])->filter();
    }

    /**
     * {@inheritDoc}
     */
    public function getAvailableTriggers(): Collection
    {
        return $this->getAvailableTriggerTypes()->transform(function (string $type) {
            return app($type);
        });
    }

    /**
     * {@inheritDoc}
     */
    public function provideTriggers(): Collection
    {
        return $this->triggers->transform(function (string $type) {
            return app($type);
        });
    }

    /**
     * Obtain trigger types that can be assigned to the model.
     *
     * @return \Illuminate\Support\Collection
     */
    protected static function getAvailableTriggerTypes(): Collection
    {
        return static::getConfigData('available-triggers');
    }
}
