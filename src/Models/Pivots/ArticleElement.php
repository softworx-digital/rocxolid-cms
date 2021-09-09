<?php

namespace Softworx\RocXolid\CMS\Models\Pivots;

// rocXolid cms model pivots
use Softworx\RocXolid\CMS\Models\Pivots\AbstractElementableElement;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\Article;

/**
 * Cross model to connect Article model with morphed elements.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class ArticleElement extends AbstractElementableElement
{
    public function parent()
    {
        return $this->belongsTo(Article::class);
    }
}
