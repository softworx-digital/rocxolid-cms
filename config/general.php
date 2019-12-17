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
        'proxyable' => [
            Softworx\RocXolid\CMS\Models\Article::class,
        ],
    ],
];