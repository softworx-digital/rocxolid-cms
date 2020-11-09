<?php

namespace Softworx\RocXolid\CMS\Models\Traits;

use Illuminate\Support\Collection;
// rocXolid trigger contracts
use Softworx\RocXolid\Triggers\Contracts\Trigger;
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
     * {@inheritDoc}
     */
    public function containsTriggerTypes(Collection $required_trigger_types): bool
    {
        // @todo: any other (non O(n^2)) way to do this w/support for subtypes?
        return $required_trigger_types->reduce(function (bool $carry, string $required_trigger_type) {
            return $carry && $this->triggers->reduce(function (bool $carry, string $trigger_type) use ($required_trigger_type) {
                return $carry || is_a($trigger_type, $required_trigger_type, true);
            }, false);
        }, true);
    }

    /**
     * {@inheritDoc}
     */
    public function allTriggersFireable(...$arguments): bool
    {
        return $this->provideTriggers()->reduce(function (bool $carry, Trigger $trigger) use ($arguments) {
            return $carry && $trigger->isFireable($this, ...$arguments);
        }, true);
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
