<?php

namespace Softworx\RocXolid\CMS\ElementableDependencies;

use Illuminate\Support\Str;
use Illuminate\View\View;
// rocXolid traits
use Softworx\RocXolid\Traits\Controllable;
use Softworx\RocXolid\Traits\TranslationPackageProvider;
use Softworx\RocXolid\Traits\TranslationParamProvider;
use Softworx\RocXolid\Traits\TranslationKeyProvider;
// rocXolid components
use Softworx\RocXolid\Components\General\Message;
// rocXolid cms elementable dependency contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependency;
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider;

/**
 * Abstract elementable dependency.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
abstract class AbstractElementDependency implements ElementableDependency
{
    use Controllable;
    use TranslationPackageProvider;
    use TranslationParamProvider;
    use TranslationKeyProvider;

    /**
     * {@inheritDoc}
     */
    public function setViewProperties(View &$view, ElementableDependencyDataProvider $data_provider): ElementableDependency
    {
        $view->with($this->getDefaultViewPropertyName(), $data_provider->getDependencyValues($this)->get($this->getDefaultViewPropertyName()));

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultViewPropertyName(): string
    {
        return Str::snake((new \ReflectionClass($this))->getShortName());
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
