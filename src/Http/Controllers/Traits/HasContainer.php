<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\Traits;

// requests
use Softworx\RocXolid\Http\Requests\CrudRequest;
// model contracts
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
// general components
use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as CrudModelViewerComponent;
use Softworx\RocXolid\Components\Forms\CrudForm as CrudFormComponent;

;
// cms components
use Softworx\RocXolid\CMS\Components\ModelViewers\ContainerViewer;

/**
 *
 */
trait HasContainer
{
    public function getContaineeClass()
    {
        return static::$containee_class;
    }

    public function getModelViewerComponent(CrudableModel $model): CrudModelViewerComponent
    {
        return ContainerViewer::build($this, $this)
            ->setModel($model)
            ->setController($this);
    }

    public function reorder(CrudRequest $request, $id, $relation)//: View
    {
        $model = $this->getRepository($this->getRepositoryParam($request))->findOrFail($id);

        if (($order = $request->input('_data', false)) && is_array($order)) {
            foreach ($order as $containee_order_data) {
                $model->reorderContainees('items', $containee_order_data);
            }
        }

        $model_viewer_component = $this->getModelViewerComponent($model);

        return $this->response
            ->notifySuccess($model_viewer_component->translate('text.updated'))
            ->get();
    }

    public function listContainee(CrudRequest $request, $id)
    {
        $repository = $this->getRepository($this->getRepositoryParam($request));

        $this->setModel($repository->find($id));

        $form = $repository->getForm($this->getFormParam($request));
        $form
            ->setContaineeClass(static::$containee_class);

        $form_component = CrudFormComponent::build($this, $this)
            ->setForm($form)
            ->setRepository($repository);

        $model_viewer_component = $this
            ->getModelViewerComponent($this->getModel())
            ->setFormComponent($form_component);

        $assignments = [
            //'page_element_short_class' => $page_element_short_class,
        ];

        return $this->response
            ->modal($model_viewer_component->fetch('modal.select-containee', $assignments))
            ->get();
    }

    public function selectContainee(CrudRequest $request, $id)
    {
        $repository = $this->getRepository($this->getRepositoryParam($request));

        $this->setModel($repository->find($id));

        $form = $repository->getForm($this->getFormParam($request));
        $form
            ->setContaineeClass(static::$containee_class)
            ->submit();

        $form_component = CrudFormComponent::build($this, $this)
            ->setForm($form)
            ->setRepository($repository);

        $model_viewer_component = $this
            ->getModelViewerComponent($this->getModel());

        if ($form->isValid()) {
            // @todo - quick hack na handlovanie radio + checkbox
            $values = $form->getFormField('containee_id')->getValue();

            if (!is_array($values)) {
                $values = [ $values ];
            }

            foreach ($values as $id) {
                $containee = $form->getContaineeModel()->find($id);

                if ($this->getModel()->hasContainee('items', $containee)) {
                    return $this->response
                        ->notifyError($model_viewer_component->translate('text.element-already-set'))
                        ->get();
                }
            }

            foreach ($values as $id) {
                $containee = $form->getContaineeModel()->find($id);

                $this->getModel()->attachContainee('items', $containee);
            }

            return $this->response->redirect($this->getModel()->getControllerRoute('show'))->get();
        /*
        return $this->response
            ->replace($model_viewer_component->getDomId('list-containee', $this->getModel()->getKey()), $model_viewer_component->fetch('include.list-containee'))
            ->modalClose($model_viewer_component->getDomId('modal-select-list-containee'))
            ->get();
        */
        } else {
            return $this->errorResponse($request, $repository, $form, 'update');
        }
    }

    public function listContaineeReplace(CrudRequest $request, $id)
    {
        $repository = $this->getRepository($this->getRepositoryParam($request));

        $this->setModel($repository->find($id));

        $form = $repository->getForm($this->getFormParam($request));
        $form
            ->setContaineeClass(static::$containee_class);

        $form_component = CrudFormComponent::build($this, $this)
            ->setForm($form)
            ->setRepository($repository);

        $model_viewer_component = $this
            ->getModelViewerComponent($this->getModel())
            ->setFormComponent($form_component);

        return $this->response
            ->modal($model_viewer_component->fetch('modal.replace-list', []))
            ->get();
    }

    public function listContaineeReplaceSubmit(CrudRequest $request, $id)
    {
        $repository = $this->getRepository($this->getRepositoryParam($request));

        $this->setModel($repository->find($id));

        $form = $repository->getForm($this->getFormParam($request));
        $form
            ->setContaineeClass(static::$containee_class)
            ->submit();

        $form_component = CrudFormComponent::build($this, $this)
            ->setForm($form)
            ->setRepository($repository);

        $model_viewer_component = $this
            ->getModelViewerComponent($this->getModel());

        if ($form->isValid()) {
            $order_by = $form->getFormField('order_by_attribute')->getValue();

            $this->reattachContainees($order_by);

            return $this->response->redirect($this->getModel()->getControllerRoute('show'))->get();
        } else {
            return $this->errorResponse($request, $repository, $form, 'update');
        }
    }

    protected function reattachContainees($order_by)
    {
        $this->getModel()->detachContainee('items');

        $items_class = static::$containee_class;

        $items_class::orderBy($order_by)->get()->each(function ($containee, $key) {
            $this->getModel()->attachContainee('items', $containee);
        });

        return $this;
    }
}
