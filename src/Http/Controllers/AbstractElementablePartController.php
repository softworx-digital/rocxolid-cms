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
use Softworx\RocXolid\CMS\Components\ModelViewers\DocumentPart as DocumentPartModelViewer;
// rocXolid cms model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable;
// @todo be more abstract
use Softworx\RocXolid\CMS\Models\Document;

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
    protected $use_ajax_destroy_confirmation = true;

    /**
     * {@inheritDoc}
     * @todo be more abstract
     */
    protected static $model_viewer_type = DocumentPartModelViewer::class;

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
            ->redirect($model->getOwner()->getControllerRoute('show', [ 'tab' => 'composition' ])) // to reload with element ids for new elements
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    protected function successAjaxStoreResponse(CrudRequest $request, CrudableModel $model, AbstractCrudForm $form)
    {
        return $this->response
            ->redirect($model->getOwner()->getControllerRoute('show', [ 'tab' => 'composition' ]))
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    protected function onModelDestroyedSuccessResponse(CrudRequest $request, CrudableModel $model)
    {
        $elementable_relation_name = $model->getOwnerRelationName();

        $elementable_part_param = sprintf('compose-%s', $elementable_relation_name);
        $elementable_form_param = sprintf('update-%s', $elementable_relation_name);

        // @todo be more abstract (pass model_type as well)
        $elementable = Document::find($request->input('_data.model_id'));
        $elementable_controller = $elementable->getCrudController();
        $elementable_form = $elementable_controller->getForm($request, $elementable, $elementable_form_param);
        $elementable_form_component = $elementable_controller->getFormComponent($elementable_form);

        $model_viewer_component = $this->getModelViewerComponent($model);

        if (is_null($elementable->{$elementable_relation_name}) || ($elementable->{$elementable_relation_name}->is($model))) {
            $elementable_model_viewer_component = $elementable_controller->getModelViewerComponent($elementable);

            $this->response
                ->destroy($elementable_model_viewer_component->getDomId($elementable_part_param));
        }

        return $this->response
            ->replace($elementable_form_component->getDomId('fieldset'), $elementable_form_component->fetch('include.fieldset'))
            ->modalClose($model_viewer_component->getDomId('modal-destroy-confirm', $model->getKey()))
            ->get();
    }
}
