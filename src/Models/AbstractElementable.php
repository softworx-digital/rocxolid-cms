<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
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
abstract class AbstractElementable extends AbstractCrudModel implements Elementable
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
    public function getTable()
    {
        return sprintf('cms_%s', parent::getTable());
    }

    /**
     * {@inheritDoc}
     */
    public function elementsPivots(): HasOneOrMany
    {
        return $this->hasMany($this->getElementsPivotType(), 'parent_id');
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
     * Obtain element types that can be assigned to the model.
     *
     * @return \Illuminate\Support\Collection
     */
    protected static function getAvailableElementTypes(): Collection
    {
        return collect(config(sprintf('rocXolid.cms.elementable.%s', static::class), config('rocXolid.cms.elementable.default', [])));
    }
}
