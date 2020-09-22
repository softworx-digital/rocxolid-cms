<?php

namespace Softworx\RocXolid\CMS\Mutators\Contracts;

// rocXolid contracts
use Softworx\RocXolid\Contracts\Paramable;
use Softworx\RocXolid\Contracts\Controllable;
use Softworx\RocXolid\Contracts\TranslationDiscoveryProvider;
use Softworx\RocXolid\Contracts\TranslationPackageProvider;
use Softworx\RocXolid\Contracts\TranslationProvider;
// rocXolid cms contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider;

/**
 * Enables to mutate a value within given context.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
interface Mutator extends Paramable, Controllable, TranslationDiscoveryProvider, TranslationProvider
{
    /**
     * Retrieve translated mutator title.
     *
     * @param \Softworx\RocXolid\Contracts\TranslationPackageProvider\TranslationPackageProvider $controller
     * @return string
     */
    public function getTranslatedTitle(TranslationPackageProvider $controller): string;

    /**
     * Retrieve translated mutator hint message.
     *
     * @param \Softworx\RocXolid\Contracts\TranslationPackageProvider\TranslationPackageProvider $controller
     * @return string
     */
    public function getHint(TranslationPackageProvider $controller): string;

    /**
     * Execute the content mutation.
     *
     * @param \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider $data_provider
     * @param string $value
     * @return string
     */
    public function mutate(ElementableDependencyDataProvider $data_provider, string $value): string;

    /**
     * Check if the mutator provides allowed selection regular expression pattern.
     *
     * @return bool
     */
    public function hasAllowedTextSelectionRegex(): bool;

    /**
     * Obtain mutator's allowed selection regular expression pattern.
     *
     * @return string
     */
    public function getAllowedTextSelectionRegex(): string;

    /**
     * Check if placeholder selection can be applied to the mutator.
     *
     * @return bool
     */
    public function isAllowedPlaceholderSelection(): bool;
}
