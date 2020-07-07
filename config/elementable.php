<?php

/**
 *--------------------------------------------------------------------------
 * Elementable models configuration.
 *--------------------------------------------------------------------------
 */
return [
    /**
     * Container element (hierarchy) used for direct component element placement.
     */
    'quick-add-element' => [
        'default' => [
            \Softworx\RocXolid\CMS\Elements\Models\GridRow::class => [
                'columns' => 1,
            ],
        ],
    ],
    /**
     * List of available elements for given elementable.
     */
    'available-elements' => [
        // fallback if target elementable is not listed
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
    /**
     * List of available dependencies for given elementable.
     */
    'available-dependencies' => [
        'default' => [
            \Softworx\RocXolid\CMS\ElementableDependencies\None::class,
        ],
    ],
    /**
     * List of available mutators for given elementable.
     */
    'available-mutators' => [
        'default' => [
            \Softworx\RocXolid\CMS\ElementableDependencies\None::class,
        ],
    ],
    /**
     * List of available styles for given elementable.
     */
    'styles' => [
        'default' => [
            // asset(mix('app.css', 'assets/css')),
        ],
        \Softworx\RocXolid\CMS\Models\Document::class => [
            'assets/css/document.min.css',
        ],
    ],
];