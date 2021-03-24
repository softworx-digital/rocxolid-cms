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
     * Flag if the frontpage routes should be registered.
     * Requires Web instance presence.
     */
    'register-frontpage-routes' => true,
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