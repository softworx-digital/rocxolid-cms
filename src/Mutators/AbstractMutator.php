<?php

namespace Softworx\RocXolid\CMS\Mutators;

// rocXolid contracts
use Softworx\RocXolid\Contracts\TranslationPackageProvider as TranslationPackageProviderContract;
// rocXolid traits
use Softworx\RocXolid\Traits\Paramable;
use Softworx\RocXolid\Traits\Controllable;
use Softworx\RocXolid\Traits\TranslationPackageProvider;
use Softworx\RocXolid\Traits\TranslationParamProvider;
use Softworx\RocXolid\Traits\TranslationKeyProvider;
// rocXolid components
use Softworx\RocXolid\Components\General\Message;
// rocXolid cms dependency contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider;
// rocXolid cms mutators contracts
use Softworx\RocXolid\CMS\Mutators\Contracts\Mutator;

/**
 * Abstract elements' content mutator implementation.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
abstract class AbstractMutator implements Mutator
{
    use Paramable;
    use Controllable;
    use TranslationPackageProvider;
    use TranslationParamProvider;
    use TranslationKeyProvider;

    const ALLOWED_SELECTION_REGEX = '';

    const ALLOWED_PLACEHOLDER_SELECTION = false;

    const ALLOWED_EXPRESSION_SELECTION = false;

    const MULTIPLE_PLACEHOLDER_SELECTION = false;

    /**
     * {@inheritDoc}
     */
    // protected $translation_package = 'rocXolid:cms'; // will throw exception, cause this is defined in the trait

    /**
     * {@inheritDoc}
     */
    public function getTranslatedTitle(TranslationPackageProviderContract $controller): string
    {
        return $this->setController($controller)->translate(sprintf('element-mutator.%s.title', $this->provideTranslationKey()));
    }

    /**
     * {@inheritDoc}
     */
    public function getHint(TranslationPackageProviderContract $controller): string
    {
        return $this->setController($controller)->translate(sprintf('element-mutator.%s.hint', $this->provideTranslationKey()));
    }

    /**
     * {@inheritDoc}
     */
    abstract public function mutate(ElementableDependencyDataProvider $data_provider, string $value): string;

    /**
     * {@inheritDoc}
     */
    public function hasAllowedTextSelectionRegex(): bool
    {
        return filled(static::ALLOWED_SELECTION_REGEX);
    }

    /**
     * {@inheritDoc}
     */
    public function getAllowedTextSelectionRegex(): string
    {
        return static::ALLOWED_SELECTION_REGEX;
    }

    /**
     * {@inheritDoc}
     */
    public function isAllowedPlaceholderSelection(): bool
    {
        return static::ALLOWED_PLACEHOLDER_SELECTION;
    }

    /**
     * {@inheritDoc}
     */
    public function isAllowedExpressionSelection(): bool
    {
        return static::ALLOWED_EXPRESSION_SELECTION;
    }

    /**
     * {@inheritDoc}
     */
    public function isMultiplePlaceholderSelection(): bool
    {
        return static::MULTIPLE_PLACEHOLDER_SELECTION;
    }

    /**
     * {@inheritDoc}
     */
    public function translate(string $key, array $params = [], bool $use_raw_key = false): string
    {
        return Message::build($this, $this->getController())->translate($key, $params, $use_raw_key);
    }

    /**
     * {@inheritDoc}
     */
    protected function guessTranslationParam(): ?string
    {
        if ($this->hasController()) {
            throw new \RuntimeException(sprintf('No controller set for [%s]', get_class($this)));
        }

        return $this->getController()->provideTranslationParam();
    }
}
