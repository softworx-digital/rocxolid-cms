<?php

namespace Softworx\RocXolid\CMS\Http\Controllers;

// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid controllers
use Softworx\RocXolid\CMS\Http\Controllers\AbstractCrudController;
// rocXolid cms model contracts
use Softworx\RocXolid\CMS\Models\Contracts\Elementable;
// rocXolid cms components
use Softworx\RocXolid\CMS\Components\ModelViewers\ElementableViewer;
// rocXolid cms services
use Softworx\RocXolid\CMS\Services\ElementableCompositionService;

/**
 * CMS controller for models that can contain elements.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
abstract class AbstractElementableController extends AbstractCrudController
{
    protected static $model_viewer_type = ElementableViewer::class;

    /**
     * {@inheritDoc}
     */
    protected $extra_services = [
        ElementableCompositionService::class,
    ];

    protected $form_mapping = [
        'create' => 'create',
        'store' => 'create',
        'edit' => 'update',
        'update' => 'update',
    ];

    public function elementSnippets(CrudRequest $request, Elementable $model)
    {
        return $this->getModelViewerComponent($model)->render('snippets');
    }

    public function storeComposition(CrudRequest $request, Elementable $model)
    {
        $model = $this->elementableCompositionService()->compose($request, $model);

        return $this->getModelViewerComponent($model)->render('snippets');
    }

// @todo
    public function preview(CrudRequest $request, Elementable $model)
    {
        $model_viewer_component = $this->getModelViewerComponent($model);

        if ($request->ajax()) {
            return $this->response
                ->modal($model_viewer_component->fetch('modal.preview'))
                ->get();
        } else {
            return $this
                ->getDashboard()
                ->setModelViewerComponent($model_viewer_component)
                ->render('model', [
                    'model_viewer_template' => 'preview'
                ]);
        }
    }








    public function selectPageElementClass(CrudRequest $request, CrudableModel $model, string $page_element_class_action)
    {
        $model_viewer_component = $this->getModelViewerComponent($model);

        return $this->response
            ->modal($model_viewer_component->fetch('modal.select-page-element-class', [
                'page_element_class_action' => $page_element_class_action,
            ]))
            ->get();
    }

    public function listPageElement(CrudRequest $request, CrudableModel $model, string $page_element_short_class)
    {
        $form = $this
            ->getForm($request, $model)
            ->setPageElementShortClass($page_element_short_class);

        $model_viewer_component = $this->getModelViewerComponent(
            $model,
            $this->getFormComponent($form)
        );

        return $this->response
            ->modal($model_viewer_component->fetch('modal.select-page-element', [
                'page_element_short_class' => $page_element_short_class,
            ]))
            ->get();
    }

    public function selectPageElement(CrudRequest $request, CrudableModel $model, string $page_element_short_class)
    {
        $form = $this
            ->getForm($request, $model)
            ->setPageElementShortClass($page_element_short_class)
            ->submit();

        $model_viewer_component = $this->getModelViewerComponent(
            $model,
            $this->getFormComponent($form)
        );

        if ($form->isValid()) {
            $page_element = $form->getPageElementModel()->find($form->getFormField('page_element_id')->getValue());

            if ($model->hasPageElement($page_element)) {
                return $this->response
                    ->notifyError($model_viewer_component->translate('text.element-already-set'))
                    ->get();
            }

            $model->addPageElement($page_element);

            return $this->response->redirect($model->getControllerRoute('show'))->get();
        /*
        return $this->response
            ->replace($model_viewer_component->getDomId('page-elements', $model->getKey()), $model_viewer_component->fetch('include.page-elements'))
            ->modalClose($model_viewer_component->getDomId('modal-select-page-element'))
            ->get();
        */
        } else {
            return $this->errorResponse($request, $model, $form, 'update');
        }
    }

    public function updatePageElementsOrder(CrudRequest $request, CrudableModel $model)
    {
        $model->updatePageElementsOrder($request);

        $model_viewer_component = $this->getModelViewerComponent($model);

        return $this->response
            //->replace($model_viewer_component->getDomId($request->_section), $model_viewer_component->fetch($template_name))
            ->notifySuccess($model_viewer_component->translate('text.updated'))
            ->get();
    }

    public function setPivotData(CrudRequest $request, CrudableModel $model, string $page_elementable_type, int $page_elementable_id)
    {
        $model->updatePivotData($request, $page_elementable_type, $page_elementable_id);

        $model_viewer_component = $this->getModelViewerComponent($model);

        return $this->response
            ->notifySuccess($model_viewer_component->translate('text.updated'))
            ->get();
    }
}