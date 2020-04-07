<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\NavigationItem;

// rocXolid fundamentals
use Softworx\RocXolid\Http\Requests\CrudRequest;
use Softworx\RocXolid\Forms\AbstractCrudForm;
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
use Softworx\RocXolid\Models\Contracts\Container;
use Softworx\RocXolid\Models\Contracts\Containee;
use Softworx\RocXolid\Repositories\Contracts\Repository;
use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as CrudModelViewerComponent;
// cms components
use Softworx\RocXolid\CMS\Components\ModelViewers\NavigationItemViewer;
// cms controllers
use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementContaineeController;
// cms models
use Softworx\RocXolid\CMS\Models\NavigationItem;

/**
 *
 */
class Controller extends AbstractPageElementContaineeController
{
    protected $form_mapping = [
        // main navigation
        'create.main-navigation-items' => 'create-in-main-navigation',
        'store.main-navigation-items' => 'create-in-main-navigation',
        'edit.main-navigation-items' => 'update-in-main-navigation',
        'update.main-navigation-items' => 'update-in-main-navigation',
        // row navigation
        'create.row-navigation-items' => 'create-in-row-navigation',
        'store.row-navigation-items' => 'create-in-row-navigation',
        'edit.row-navigation-items' => 'update-in-row-navigation',
        'update.row-navigation-items' => 'update-in-row-navigation',
    ];

    public function getModelViewerComponent(CrudableModel $model): CrudModelViewerComponent
    {
        return NavigationItemViewer::build($this, $this)
            ->setModel($model)
            ->setController($this);
    }

    protected function handleMainNavigationItemsCreate(CrudRequest $request, AbstractCrudForm $form, Containee $containee, Container $container)
    {
        $this->response->redirect($container->getControllerRoute());

        return $this;
    }

    protected function handleMainNavigationItemsUpdate(CrudRequest $request, AbstractCrudForm $form, Containee $containee, Container $container)
    {
        return $this->updateContaineeResponse($request, $container);
    }

    protected function handleRowNavigationItemsCreate(CrudRequest $request, AbstractCrudForm $form, Containee $containee, Container $container)
    {
        $this->response->redirect($container->getControllerRoute());

        return $this;
    }

    protected function handleRowNavigationItemsUpdate(CrudRequest $request, AbstractCrudForm $form, Containee $containee, Container $container)
    {
        return $this->updateContaineeResponse($request, $container);
    }
}
