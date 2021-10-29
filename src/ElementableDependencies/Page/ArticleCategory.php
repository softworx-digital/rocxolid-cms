<?php

namespace Softworx\RocXolid\CMS\ElementableDependencies\Page;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
// rocXolid contracts
use Softworx\RocXolid\Contracts\TranslationPackageProvider;
// rocXolid models
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Web;
use Softworx\RocXolid\Common\Models\Localization;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\Page;
// rocXolid cms elementable dependency traits
use Softworx\RocXolid\CMS\ElementableDependencies\Traits\RouteDependency;
// rocXolid cms elementable dependency contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependency;
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\RoutePathParamsProvider;
// rocXolid cms elementable dependencies
use Softworx\RocXolid\CMS\ElementableDependencies\AbstractElementableDependency;

/**
 * Provide ArticleCategory dependency for elementable.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class ArticleCategory extends AbstractElementableDependency implements RoutePathParamsProvider
{
    use RouteDependency;

    /**
     * {@inheritDoc}
     */
    protected function prepareModelPresentation(Request $request, Web $web, Localization $localization, Page $page, Crudable $model, string $slug = null): ElementableDependency
    {
        $model->setPresenting($page->isPresenting());

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    protected function isModelEnabled(Crudable $model): bool
    {
        return $model->is_enabled;
    }

    /**
     * {@inheritDoc}
     */
    public function validateAssignmentData(Collection $data, string $attribute): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function assignmentValidationErrorMessage(TranslationPackageProvider $controller, Collection $data): string
    {
        return '';
    }
}
