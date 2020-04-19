<?php

return [
    'default' => [
        // basic
        \Softworx\RocXolid\CMS\Elements\Models\Text::class,
    ],
    // document
    \Softworx\RocXolid\CMS\Models\Document::class => [
        \Softworx\RocXolid\CMS\Elements\Models\Text::class,
    ],
    // article
    \Softworx\RocXolid\CMS\Models\Article::class => [
        \Softworx\RocXolid\CMS\Elements\Models\Text::class,
    ],
];