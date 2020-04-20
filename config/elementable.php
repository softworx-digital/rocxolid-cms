<?php

return [
    'default' => [
        // layout
        \Softworx\RocXolid\CMS\Elements\Models\GridRow::class,
        // basic
        \Softworx\RocXolid\CMS\Elements\Models\Text::class,
    ],
    // document
    \Softworx\RocXolid\CMS\Models\Document::class => [
        \Softworx\RocXolid\CMS\Elements\Models\GridRow::class,
        \Softworx\RocXolid\CMS\Elements\Models\Text::class,
    ],
    // article
    \Softworx\RocXolid\CMS\Models\Article::class => [
        \Softworx\RocXolid\CMS\Elements\Models\Text::class,
    ],
];