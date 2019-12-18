<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\RowNavigation;

// requests
use Softworx\RocXolid\Http\Requests\CrudRequest;
// model contracts
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
// general components
use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as CrudModelViewerComponent;
// cms components
use Softworx\RocXolid\CMS\Components\ModelViewers\RowNavigationViewer;
// cms controllers
use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementController;
// cms repositories
use Softworx\RocXolid\CMS\Repositories\RowNavigation\Repository;
// cms models
use Softworx\RocXolid\CMS\Models\RowNavigation;
/**
 *
 */
class Controller extends AbstractPageElementController
{
    protected static $model_class = RowNavigation::class;

    protected static $repository_class = Repository::class;

    public function getModelViewerComponent(CrudableModel $model): CrudModelViewerComponent
    {
        return RowNavigationViewer::build($this, $this)
            ->setModel($model)
            ->setController($this);
    }

    public function reorder(CrudRequest $request, $id, $relation)//: View
    {
        $model = $this->getRepository($this->getRepositoryParam($request))->findOrFail($id);

        if (($order = $request->input('_data', false)) && is_array($order))
        {
            foreach ($order as $containee_order_data)
            {
                $model->reorderContainees('items', $containee_order_data);
            }
        }

        $model_viewer_component = $this->getModelViewerComponent($model);

        return $this->response
            ->notifySuccess($model_viewer_component->translate('text.updated'))
            ->get();
    }
}