<?php

namespace Softworx\RocXolid\CMS\Rendering\Traits;

// rocXolid cms rendering contracts
use Softworx\RocXolid\CMS\Rendering\Contracts\Themeable;

/**
 * Enables object to be theme-rendered at the front-end.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
trait CanBeThemed
{
    /**
     * Enables to define theme directory containing views for component using this trait.
     *
     * @var string
     */
    protected $view_theme;

    /**
     * {@inheritdoc}
     */
    public function setViewTheme(string $theme): Themeable
    {
        $this->setViewPackage(static::THEME_PACKAGE);

        $this->view_theme = $theme;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getViewTheme(): string
    {
        return $this->view_theme ?? '';
    }

    /**
     * {@inheritdoc}
     */
    public function hasViewTheme(): bool
    {
        return !is_null($this->view_theme);
    }

    /**
     * {@inheritDoc}
     */
    public function composePackageViewPaths(string $view_package, string $view_dir, string $view_name): array
    {
        if ($this->hasViewTheme()) {
            $paths = [];

            $paths['with_model_name'] = sprintf(
                '%s::%s.%s.%s.%s',
                $view_package,
                $this->getViewTheme(),
                $view_dir,
                $this->getModel()->getModelName(),
                $view_name
            );

            $paths['without_model_name'] = sprintf(
                '%s::%s.%s.%s',
                $view_package,
                $this->getViewTheme(),
                $view_dir,
                $view_name
            );

            $paths['with_model_name_without_theme'] = sprintf(
                '%s::%s.%s.%s',
                $view_package,
                $view_dir,
                $this->getModel()->getModelName(),
                $view_name
            );

            $paths['without_model_name_without_theme'] = sprintf(
                '%s::%s.%s',
                $view_package,
                $view_dir,
                $view_name
            );

            return $paths;
        }

        return parent::composePackageViewPaths($view_package, $view_dir, $view_name);
    }
}
