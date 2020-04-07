<?php

namespace Softworx\RocXolid\CMS\Http\Controllers;

// utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
use Softworx\RocXolid\Http\Responses\Contracts\AjaxResponse;
//
use Softworx\RocXolid\Components\Forms\CrudForm as CrudFormComponent;
//
use Softworx\RocXolid\CMS\Http\Controllers\AbstractCrudController;
// contracts
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
// general components
use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as CrudModelViewerComponent;
// cms components
use Softworx\RocXolid\CMS\Components\ModelViewers\PageElementableViewer;

/**
 *
 */
abstract class AbstractPageElementableController extends AbstractCrudController
{
    protected $form_mapping = [
        'create' => 'create',
        'store' => 'create',
        'edit' => 'update',
        'update' => 'update',
        'listPageElement' => 'list-page-element',
        'selectPageElement' => 'list-page-element',
    ];

    public function getModelViewerComponent(CrudableModel $model): CrudModelViewerComponent
    {
        return PageElementableViewer::build($this, $this)
            ->setModel($model)
            ->setController($this);
    }
// @todo
    public function preview(CrudRequest $request, CrudableModel $model)
    {
        // $repository = $this->getRepository($this->getRepositoryParam($request));
        // $model = $repository->find($id);

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

    public function selectPageElementClass(CrudRequest $request, $id, $page_element_class_action)
    {
        $repository = $this->getRepository($this->getRepositoryParam($request));

        $this->setModel($repository->find($id));

        $model_viewer_component = $this
            ->getModelViewerComponent($this->getModel());

        $assignments = [
            'page_element_class_action' => $page_element_class_action,
        ];

        return $this->response
            ->modal($model_viewer_component->fetch('modal.select-page-element-class', $assignments))
            ->get();
    }

    public function listPageElement(CrudRequest $request, $id, $page_element_short_class)
    {
        $repository = $this->getRepository($this->getRepositoryParam($request));

        $this->setModel($repository->find($id));

        $form = $repository->getForm($this->getFormParam($request));
        $form
            ->setPageElementShortClass($page_element_short_class);

        $form_component = CrudFormComponent::build($this, $this)
            ->setForm($form)
            ->setRepository($repository);

        $model_viewer_component = $this
            ->getModelViewerComponent($this->getModel())
            ->setFormComponent($form_component);

        $assignments = [
            'page_element_short_class' => $page_element_short_class,
        ];

        return $this->response
            ->modal($model_viewer_component->fetch('modal.select-page-element', $assignments))
            ->get();
    }

    public function selectPageElement(CrudRequest $request, $id, $page_element_short_class)
    {
        $repository = $this->getRepository($this->getRepositoryParam($request));

        $this->setModel($repository->find($id));

        $form = $repository->getForm($this->getFormParam($request));
        $form
            ->setPageElementShortClass($page_element_short_class)
            ->submit();

        $form_component = CrudFormComponent::build($this, $this)
            ->setForm($form)
            ->setRepository($repository);

        $model_viewer_component = $this
            ->getModelViewerComponent($this->getModel());

        if ($form->isValid()) {
            $page_element = $form->getPageElementModel()->find($form->getFormField('page_element_id')->getValue());

            if ($this->getModel()->hasPageElement($page_element)) {
                return $this->response
                    ->notifyError($model_viewer_component->translate('text.element-already-set'))
                    ->get();
            }

            $this->getModel()->addPageElement($page_element);

            return $this->response->redirect($this->getModel()->getControllerRoute('show'))->get();
        /*
        return $this->response
            ->replace($model_viewer_component->getDomId('page-elements', $this->getModel()->getKey()), $model_viewer_component->fetch('include.page-elements'))
            ->modalClose($model_viewer_component->getDomId('modal-select-page-element'))
            ->get();
        */
        } else {
            return $this->errorResponse($request, $this->getRepository()->getModel(), $form, 'update');
        }
    }

    public function updatePageElementsOrder(CrudRequest $request, $id)
    {
        $repository = $this->getRepository($this->getRepositoryParam($request));

        $this->setModel($repository->find($id));
        $this->getModel()->updatePageElementsOrder($request);

        $model_viewer_component = $this
            ->getModelViewerComponent($this->getModel());

        return $this->response
            //->replace($model_viewer_component->getDomId($request->_section), $model_viewer_component->fetch($template_name))
            ->notifySuccess($model_viewer_component->translate('text.updated'))
            ->get();
    }

    public function setPivotData(CrudRequest $request, $id, $page_elementable_type, $page_elementable_id)
    {
        $repository = $this->getRepository($this->getRepositoryParam($request));

        $this->setModel($repository->find($id));
        $this->getModel()->updatePivotData($request, $page_elementable_type, $page_elementable_id);

        $model_viewer_component = $this
            ->getModelViewerComponent($this->getModel());

        return $this->response
            ->notifySuccess($model_viewer_component->translate('text.updated'))
            ->get();
    }
}
