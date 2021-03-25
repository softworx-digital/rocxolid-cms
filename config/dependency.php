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
];