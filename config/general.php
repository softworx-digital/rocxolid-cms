<?php

/**
 *--------------------------------------------------------------------------
 * General CMS configuration.
 *--------------------------------------------------------------------------
 */
return [
    /**
     * Page configuration.
     */
    'page' => [
        // items that can be proxied (assigned to a proxy page)
        'proxyable' => [
            Softworx\RocXolid\CMS\Models\Article::class,
        ],
    ],
];