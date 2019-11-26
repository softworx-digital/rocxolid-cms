<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\MainSlider;

// requests
use Softworx\RocXolid\Http\Requests\CrudRequest;
// model contracts
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel,
    Softworx\RocXolid\Models\Contracts\Containee,
    Softworx\RocXolid\Models\Contracts\Container;
// general components
use Softworx\RocXolid\Components\General\Message,
    Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as CrudModelViewerComponent;
// cms components
use Softworx\RocXolid\CMS\Components\ModelViewers\SliderViewer;
// cms controllers
use Softworx\RocXolid\CMS\Http\Controllers\AbstractPageElementController;
// cms repositories
use Softworx\RocXolid\CMS\Repositories\MainSlider\Repository;
// cms models
use Softworx\RocXolid\CMS\Models\MainSlider;
/**
 *
 */
class Controller extends AbstractPageElementController
{
    protected static $model_class = MainSlider::class;

    protected static $repository_class = Repository::class;

    public function getModelViewerComponent(CrudableModel $model): CrudModelViewerComponent
    {
        return (new SliderViewer())
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
            ->append($model_viewer_component->getDomId('output-icon'), (new Message())->fetch('input-feedback.success'))
            ->get();
    }
}