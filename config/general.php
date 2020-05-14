<?php

/**
 *--------------------------------------------------------------------------
 * General CMS configuration.
 *--------------------------------------------------------------------------
 */
return [
    /**
     * View composers.
     */
    'composers' => [
        'themes::*' => \Softworx\RocXolid\CMS\Composers\ThemeViewComposer::class, // binds variables to themes templates
    ],
    /**
     * Page configuration.
     */
    'page' => [
        // items that can be proxied (assigned to a proxy page)
        'proxyable' => [
            \Softworx\RocXolid\CMS\Models\Article::class,
        ],
    ],
];