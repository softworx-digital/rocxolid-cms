<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\SliderItem;

// rocXolid fundamentals
use Softworx\RocXolid\Http\Requests\CrudRequest;
use Softworx\RocXolid\Forms\AbstractCrudForm;
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
use Softworx\RocXolid\Models\Contracts\Container;
use Softworx\RocXolid\Models\Contracts\Containee;
use Softworx\RocXolid\Repositories\Contracts\Repository;
use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as CrudModelViewerComponent;
// cms components
use Softworx\RocXolid\CMS\Components\ModelViewers\SliderItemViewer;
// cms controllers
use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementContaineeController;
// cms repositories
use Softworx\RocXolid\CMS\Repositories\SliderItem\Repository as SliderItemRepository;
// cms models
use Softworx\RocXolid\CMS\Models\SliderItem;

/**
 *
 */
class Controller extends AbstractPageElementContaineeController
{


    protected static $repository_class = SliderItemRepository::class;

    protected $form_mapping = [
        // main slider
        'create.main-slider-items' => 'create-in-main-slider',
        'store.main-slider-items' => 'create-in-main-slider',
        'edit.main-slider-items' => 'update-in-main-slider',
        'update.main-slider-items' => 'update-in-main-slider',
    ];

    public function getModelViewerComponent(CrudableModel $model): CrudModelViewerComponent
    {
        return SliderItemViewer::build($this, $this)
            ->setModel($model)
            ->setController($this);
    }

    protected function handleMainSliderItemsCreate(CrudRequest $request, Repository $repository, AbstractCrudForm $form, Containee $containee, Container $container)
    {
        $this->response->redirect($container->getControllerRoute());

        return $this;
    }

    protected function handleMainSliderItemsUpdate(CrudRequest $request, Repository $repository, AbstractCrudForm $form, Containee $containee, Container $container)
    {
        return $this->updateContaineeResponse($request, $container);
    }
}
