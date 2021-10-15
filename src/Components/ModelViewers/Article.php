<?php

namespace Softworx\RocXolid\CMS\Components\ModelViewers;

// rocXolid CMS components
use Softworx\RocXolid\CMS\Components\ModelViewers\AbstractElementableModelViewer;

/**
 * Article model viewer component.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class Article extends AbstractElementableModelViewer
{
    /**
     * @inheritDoc
     */
    protected $panels = [
        'data' => [
            'general' => [
                'is_enabled',
                'is_featured',
                'is_newsflash',
                'web_id',
                'localization_id',
                'author_id',
                'article_category_id',
                'date',
                'title',
                'tags',
            ],
            'meta' => [
                'meta_title',
                'meta_description',
                'meta_keywords',
            ],
            'related' => [
                'related',
            ],
            'perex' => [
                'perex',
            ],
        ],
    ];
}
