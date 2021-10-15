<?php

/**
 *--------------------------------------------------------------------------
 * Elementable models dependencies configuration.
 *--------------------------------------------------------------------------
 */
return [
    /**
     * List of available placeholders for given dependency in the form:
     *
     * ```
     * <dependency-class-name> => [
     *      <placeholder-title> => [
     *          'token' => <placeholder-token>
     *          ...(other options)
     *      ],
     *      ...(other placeholder definition)
     * ],
     * ...(other dependency)
     * ```
     */
    'data-placeholders' => [
        Softworx\RocXolid\CMS\ElementableDependencies\General::class => [
            'current_date' => [
                'token' => 'general::getCurrentDate',
            ],
        ],
    ],
    /**
     * List of dependency keys and their representative classes to identify appropriate connections.
     */
    'semantics' => [
        'article' => \Softworx\RocXolid\CMS\ElementableDependencies\Page\Article::class,
        'article-category' => \Softworx\RocXolid\CMS\ElementableDependencies\Page\ArticleCategory::class,
        'article-tag' => \Softworx\RocXolid\CMS\ElementableDependencies\Page\ArticleTag::class,
    ],
];