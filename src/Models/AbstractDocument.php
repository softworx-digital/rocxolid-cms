<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;
// rocXolid common traits
use Softworx\RocXolid\Common\Models\Traits\HasWeb;
use Softworx\RocXolid\Common\Models\Traits\UserGroupAssociatedWeb;
use Softworx\RocXolid\Common\Models\Traits\HasLocalization;
// rocXolid cms elements models contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable;
// rocXolid cms elements models traits
use Softworx\RocXolid\CMS\Elements\Models\Traits\HasElements;

/**
 * Elementable model abstraction.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
abstract class AbstractDocument extends AbstractCrudModel implements Elementable
{
    use SoftDeletes;
    use HasWeb;
    use UserGroupAssociatedWeb;
    use HasLocalization;
    use HasElements;

    /**
     * {@inheritDoc}
     */
    protected $relationships = [
        'web',
        'localization',
    ];

    /**
     * {@inheritDoc}
     */
    public function fillCustom(Collection $data): Crudable
    {
        $this->dependencies = json_encode($data->get('dependencies'));

        return parent::fillCustom($data);
    }

    /**
     * {@inheritDoc}
     */
    public function elementsPivots(): HasOneOrMany
    {
        return $this->hasMany($this->getElementsPivotType(), 'parent_id');
    }

    // @todo: refactor
    public function getDependenciesAttribute($value): Collection
    {
        return collect($value ? json_decode($value) : [])->filter();
    }

    public function getDependencies(): Collection
    {
        return $this->dependencies->map(function ($dependency_type) {
            return app($dependency_type);
        });
    }

    /**
     * Obtain available element models that can be assigned to the model.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAvailableElements(): Collection
    {
        return $this->getAvailableElementTypes()->map(function ($type) {
            return app($type);
        });
    }

    /**
     * Obtain available dependencies that can be assigned to the model.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAvailableDependencies(): Collection
    {
        return $this->getAvailableDependencyTypes()->map(function ($type) {
            return app($type);
        });
    }

    /**
     * Provide view theme to underlying elements.
     *
     * @return \Illuminate\Support\Collection
     */
    public function provideViewTheme(): string
    {
        return $this->theme;
    }

    /**
     * Obtain element types that can be assigned to the model.
     *
     * @return \Illuminate\Support\Collection
     */
    protected static function getAvailableElementTypes(): Collection
    {
        $config = static::getConfigFilePathKey();

        return collect(config(sprintf('%s.available-elements.%s', $config, static::class), config(sprintf('%s.available-elements.default', $config), [])));
    }

    /**
     * Obtain dependency types that can be assigned to the model.
     *
     * @return \Illuminate\Support\Collection
     */
    protected static function getAvailableDependencyTypes(): Collection
    {
        $config = static::getConfigFilePathKey();

        return collect(config(sprintf('%s.available-dependencies.%s', $config, static::class), config(sprintf('%s.available-dependencies.default', $config), [])));
    }

    /**
     * Obtain config file path key.
     *
     * @return string
     */
    protected static function getConfigFilePathKey(): string
    {
        return 'rocXolid.cms.elementable';
    }
}
