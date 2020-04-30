<?php

return [
    'available-elements' => [
        'default' => [
            // layout
            \Softworx\RocXolid\CMS\Elements\Models\GridRow::class,
            // basic
            \Softworx\RocXolid\CMS\Elements\Models\Text::class,
        ],
        // document
        \Softworx\RocXolid\CMS\Models\Document::class => [
            \Softworx\RocXolid\CMS\Elements\Models\GridRow::class => [
                'columns' => 1,
            ],
            \Softworx\RocXolid\CMS\Elements\Models\Text::class,
        ],
        // article
        \Softworx\RocXolid\CMS\Models\Article::class => [
            \Softworx\RocXolid\CMS\Elements\Models\Text::class,
        ],
    ],
    'available-dependencies' => [
        'default' => [
            \Softworx\RocXolid\CMS\ElementableDependencies\None::class,
        ],
    ],
];