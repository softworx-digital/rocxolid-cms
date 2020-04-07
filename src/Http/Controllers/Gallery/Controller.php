<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\Gallery;

// base requests
use Softworx\RocXolid\Http\Requests\CrudRequest;
// base forms
use Softworx\RocXolid\Forms\AbstractCrudForm;
// base models
use Softworx\RocXolid\Models\Contracts\Container;
use Softworx\RocXolid\Models\Contracts\Containee;
// base components
use Softworx\RocXolid\Components\Forms\CrudForm as CrudFormComponent;
// cms controllers
use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementController;
// cms models
use Softworx\RocXolid\CMS\Models\Gallery;

/**
 *
 */
class Controller extends AbstractPageElementController
{
    protected $form_mapping = [
        'create' => 'create',
        'store' => 'create',
        'edit' => 'update',
        'update' => 'update',
        'create.page-elements' => 'create-in-page-elementable',
        'store.page-elements' => 'create-in-page-elementable',
        'edit.page-elements' => 'update-in-page-elementable',
        'update.page-elements' => 'update-in-page-elementable',
        'clearConfirmation.page-elements' => 'clear-in-page-elementable',
        'clear.page-elements' => 'clear-in-page-elementable',
    ];

    public function regenerateConfirmation(CrudRequest $request, Gallery $gallery)
    {
    }

    public function regenerate(CrudRequest $request, Gallery $gallery)
    {
    }

    public function clearConfirmation(CrudRequest $request, Gallery $gallery)
    {
        $model_viewer_component = $this->getModelViewerComponent(
            $gallery,
            $this->getFormComponent($this->getForm($request, $gallery))
        );

        return $this->response
            ->modal($model_viewer_component->fetch('modal.clear-confirmation', []))
            ->get();
    }

    public function clear(CrudRequest $request, Gallery $gallery)
    {
        $gallery->images()->delete();

        $form = $this->getForm($request, $gallery);

        return $this->successResponse($request, $repository, $form, $gallery, 'clear');
    }

    protected function handlePageElementsClear(CrudRequest $request, AbstractCrudForm $form, $containee, $container)
    {
        $this->response->redirect($container->getControllerRoute());

        return $this;
    }
}
