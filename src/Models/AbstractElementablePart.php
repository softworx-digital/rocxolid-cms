<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations;
// rocXolid form contracts
use Softworx\RocXolid\Forms\Contracts\FormField;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\AbstractElementable;
use Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProvider;
use Softworx\RocXolid\CMS\Models\Contracts\ElementsMutatorsProvider;
// rocXolid cms mutators contracts
use Softworx\RocXolid\CMS\Mutators\Contracts\Mutator;
// rocXolid cms elements models contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable;

/**
 * Elementable part abstraction.
 * Can be assigned to several elementables.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
abstract class AbstractElementablePart extends AbstractElementable
{
    /**
     * Type to use as owning elementable.
     *
     * @var string
     */
    protected static $elementable_type;

    /**
     * Owning elementable reference.
     *
     * @var \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable
     */
    protected $elementable;

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'is_enabled',
        'web_id',
        'localization_id',
        'is_bound',
        'title',
    ];

    /**
     * {@inheritDoc}
     */
    protected $relationships = [
        'web',
        'localization',
        'elementables'
    ];

    /**
     * {@inheritDoc}
     */
    protected static $title_column = 'title';

    /**
     * {@inheritDoc}
     */
    public function resolveRouteBinding($value, $field = null)
    {
        $model = $this->where($this->getRouteKeyName(), $value)->first();

        if (request()->has($this->getBindingKey()) && ($elementable = static::$elementable_type::find(request()->get($this->getBindingKey())))) {
            $model->setOwner($elementable);
        }

        return $model;
    }

    /**
     * {@inheritDoc}
     */
    public function initAsFieldItem(FormField $form_field)
    {
        if ($form_field->getForm()->getRequest()->has($this->getBindingKey()) && ($elementable = static::$elementable_type::find(request()->get($this->getBindingKey())))) {
            $this->setOwner($elementable);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    protected function getControllerRouteDefaultParams(string $method): array
    {
        return isset($this->elementable) ? [
            $this->getBindingKey() => $this->elementable->getKey()
        ] : [];
    }

    /**
     * {@inheritDoc}
     */
    public function onCreateBeforeSave(Collection $data): Crudable
    {
        $this->setOwner(static::$elementable_type::find($data->get($this->getBindingKey())));

        $this->web()->associate($this->getOwner()->web);
        $this->localization()->associate($this->getOwner()->localization);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getAvailableDependencies(): Collection
    {
        return $this->getOwner()->getAvailableDependencies();
    }

    /**
     * {@inheritDoc}
     */
    public function provideDependencies(bool $sub = false): Collection
    {
        return $this->getOwner()->provideDependencies($sub);
    }

    /**
     * {@inheritDoc}
     */
    public function provideViewTheme(): string
    {
        return $this->getOwner()->provideViewTheme();
    }

    /**
     * {@inheritDoc}
     */
    public function provideMutators(): Collection
    {
        return $this->getOwner()->provideMutators();
    }

    /**
     * {@inheritDoc}
     */
    public function getMutator(string $key): ?Mutator
    {
        return $this->getOwner()->getMutator($key);
    }

    /**
     * Set owning elementable to be able to provide dependencies for underlying elements.
     *
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable $elementable
     * @return \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable
     */
    public function setOwner(Elementable $elementable): Elementable
    {
        $this->elementable = $elementable;

        return $this;
    }

    /**
     * Set owning elementable to be able to provide dependencies for underlying elements.
     *
     * @return \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable
     * @throws \RuntimeException
     */
    public function getOwner(): Elementable
    {
        if (!isset($this->elementable)) {
            throw new \RuntimeException(sprintf('Owner not yet set to [%s]', get_class($this)));
        }

        return $this->elementable;
    }

    /**
     * Relation name that elementable has to its part.
     *
     * @return string
     */
    abstract public function getOwnerRelationName(): string;

    /**
     * Relation that elementable has to its part.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getOwnerRelation(): Relations\BelongsTo
    {
        return $this->getOwner()->{$this->getOwnerRelationName()}();
    }

    /**
     * Relation to elementables.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function elementables(): Relations\HasMany
    {
        return $this->hasMany(static::$elementable_type);
    }

    /**
     * {@inheritDoc}
     */
    public function getDependenciesProvider(): ElementsDependenciesProvider
    {
        return $this->getOwner();
    }

    /**
     * {@inheritDoc}
     */
    public function getMutatorsProvider(): ElementsMutatorsProvider
    {
        return $this->getOwner();
    }

    /**
     * Check if elementable part is bound to elementable instance and cannot be used elsewhere.
     *
     * @return bool
     */
    abstract public function isBoundToElementable(): bool;

    /**
     * Obtain the binding key for parent relation.
     *
     * @return string
     */
    protected function getBindingKey(): string
    {
        return static::$elementable_type::make()->getForeignKey();
    }
}
