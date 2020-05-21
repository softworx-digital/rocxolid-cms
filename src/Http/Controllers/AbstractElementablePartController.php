<?php

namespace Softworx\RocXolid\CMS\Http\Controllers;

// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid controller contracts
use Softworx\RocXolid\Http\Controllers\Contracts\Crudable;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
// rocXolid cms controllers
use Softworx\RocXolid\CMS\Http\Controllers\AbstractElementableController;
// rocXolid cms components
use Softworx\RocXolid\CMS\Components\ModelViewers\DocumentPartViewer;
// rocXolid cms model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable;

/**
 * CMS controller for models that can contain elements.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
abstract class AbstractElementablePartController extends AbstractElementableController
{
    /**
     * {@inheritDoc}
     */
    protected static $model_viewer_type = DocumentPartViewer::class;

    /**
     * {@inheritDoc}
     */
    protected function onModelStored(CrudRequest $request, CrudableModel $model, AbstractCrudForm $form): Crudable
    {
        $model->getOwnerRelation()->associate($model)->save();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    protected function successCompositionStoredResponse(CrudRequest $request, Elementable $model)
    {
        $model_viewer_component = $this->getModelViewerComponent($model);

        return $this->response
            ->notifySuccess($model_viewer_component->translate('text.updated'))
            ->redirect($model->getOwner()->getControllerRoute('show')) // to reload with element ids for new elements
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    protected function successAjaxStoreResponse(CrudRequest $request, CrudableModel $model, AbstractCrudForm $form)
    {
        return $this->response
            ->redirect($model->getOwner()->getControllerRoute('show'))
            ->get();
    }
}
