<?php

namespace Softworx\RocXolid\CMS\Rendering\Traits;

// rocXolid cms rendering contracts
use Softworx\RocXolid\CMS\Rendering\Contracts\Themeable;
// rocXolid rendering service contracts
use Softworx\RocXolid\Rendering\Services\Contracts\RenderingService;

/**
 * Enables object to be theme-rendered at the front-end.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid
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
     * Retrieve the rendering service responsible for retrieving and composing the views.
     *
     * @return \Softworx\RocXolid\Rendering\Services\Contracts\RenderingService
     * @todo: find a way to inject dependency w/out explicit constructor
     */
    protected function getRenderingService(): RenderingService
    {
        if (!filled($this->rendering_service)) {
            $this->rendering_service = app(RenderingService::class);
        }

        return $this->rendering_service;
    }
}
