<?php

namespace Softworx\RocXolid\CMS\ElementableDependencies\Data;

// rocXolid contracts
use Softworx\RocXolid\Contracts\Optionable;
use Softworx\RocXolid\Contracts\TranslationProvider;
use Softworx\RocXolid\Contracts\TranslationPackageProvider;
// rocXolid traits
use Softworx\RocXolid\Traits\MethodOptionable;
// rocXolid cms elementable dependency contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependency;

/**
 * Dependency data placeholder wrapper used in content composition.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid
 * @version 1.0.0
 */
class Placeholder implements Optionable
{
    use MethodOptionable;

    /**
     * Dependency reference.
     *
     * @var \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependency
     */
    protected $dependency;

    /**
     * Placeholder system name.
     *
     * @var string
     */
    protected $name;

    /**
     * Dependency tag to be compiled to real value.
     *
     * @var string
     */
    protected $token;

    /**
     * Constructor.
     *
     * @param \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependency $dependency
     * @param array $options
     */
    public function __construct(ElementableDependency $dependency, string $name, array $options)
    {
        $this
            ->setDependency($dependency)
            ->setName($name)
            ->setOptions($options);
    }

    /**
     * Set dependency reference.
     *
     * @param \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependency $dependency Dependency reference.
     * @return \Softworx\RocXolid\CMS\ElementableDependencies\Data\Placeholder
     */
    public function setDependency(ElementableDependency $dependency): Placeholder
    {
        $this->dependency = $dependency;

        return $this;
    }

    /**
     * Get dependency reference.
     *
     * @return \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependency
     */
    public function getDependency(): ElementableDependency
    {
        return $this->dependency;
    }

    /**
     * Set placeholder system name.
     *
     * @param string $name Dependency name.
     * @return \Softworx\RocXolid\CMS\ElementableDependencies\Data\Placeholder
     */
    public function setName(string $name): Placeholder
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get placeholder system name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get translated meaningful placeholder title.
     *
     * @return string
     */
    public function getTranslatedTitle(TranslationPackageProvider $controller): string
    {
        // @todo: hotfixed
        if ($this->getDependency() instanceof TranslationProvider) {
            return $this->getDependency()->setController($controller)->translate(sprintf(
                'element-dependency.%s.placeholder.%s',
                $this->getDependency()->provideTranslationKey(),
                $this->getName()
            ));
        }

        return $this->getName();
    }

    /**
     * Set the value of dependency token.
     *
     * @param string $token
     * @return \Softworx\RocXolid\CMS\ElementableDependencies\Data\Placeholder
     */
    public function setToken(string $token): Placeholder
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get the value of dependency token.
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
}
