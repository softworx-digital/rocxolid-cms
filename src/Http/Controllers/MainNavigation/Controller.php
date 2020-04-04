<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\MainNavigation;

// requests
use Softworx\RocXolid\Http\Requests\CrudRequest;
// model contracts
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
use Softworx\RocXolid\Models\Contracts\Containee;
use Softworx\RocXolid\Models\Contracts\Container;
// general components
use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as CrudModelViewerComponent;
// cms components
use Softworx\RocXolid\CMS\Components\ModelViewers\NavigationViewer;
// cms controllers
use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementController;
// cms models
use Softworx\RocXolid\CMS\Models\MainNavigation;

/**
 *
 */
class Controller extends AbstractPageElementController
{
    public function getModelViewerComponent(CrudableModel $model): CrudModelViewerComponent
    {
        return NavigationViewer::build($this, $this)
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
}
