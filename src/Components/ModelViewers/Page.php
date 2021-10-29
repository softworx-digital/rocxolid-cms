<?php

namespace Softworx\RocXolid\CMS\Components\ModelViewers;

// rocXolid CMS components
use Softworx\RocXolid\CMS\Components\ModelViewers\AbstractElementableModelViewer;

/**
 * Page model viewer component.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class Page extends AbstractElementableModelViewer
{
    /**
     * @inheritDoc
     */
    protected $panels = [
        'data' => [
            'general' => [
                'is_enabled',
                'is_web_localization_homepage',
                'web_id',
                'localization_id',
                // 'page_template_id',
                'name',
                'path',
                'theme',
            ],
            'meta' => [
                'meta_title',
                'meta_description',
                'meta_keywords',
            ],
        ],
    ];
}
