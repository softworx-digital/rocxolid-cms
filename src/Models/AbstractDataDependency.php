<?php

namespace Softworx\RocXolid\CMS\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;

/**
 * Document part abstraction.
 * Can be assigned to several documents.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
abstract class AbstractDataDependency extends AbstractCrudModel
{
    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'web_id',
        'localization_id',
        'title',
    ];

    /**
     * {@inheritDoc}
     */
    protected $relationships = [
        'web',
        'localization'
    ];

    /**
     * {@inheritDoc}
     */
    protected static $title_column = 'title';
}
