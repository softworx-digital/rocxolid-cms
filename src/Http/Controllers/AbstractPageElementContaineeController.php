<?php

namespace Softworx\RocXolid\CMS\Http\Controllers;

use App;
use Illuminate\Support\Collection;
// rocXolid fundamentals
use Softworx\RocXolid\Http\Requests\CrudRequest,
    Softworx\RocXolid\Forms\AbstractCrudForm,
    Softworx\RocXolid\Forms\Contracts\FormField,
    Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel,
    Softworx\RocXolid\Models\Contracts\Container,
    Softworx\RocXolid\Models\Contracts\Containee,
    Softworx\RocXolid\Repositories\Contracts\Repository,
    Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as CrudModelViewerComponent;
// general components
use Softworx\RocXolid\Components\General\Message,
    Softworx\RocXolid\Components\Forms\CrudForm as CrudFormComponent;
// cms controllers
use Softworx\RocXolid\CMS\Http\Controllers\AbstractCrudController as AbstractCMSController;
/**
 *
 */
abstract class AbstractPageElementContaineeController extends AbstractCMSController
{
    public function getContainer(CrudRequest $request)
    {
        if (!$request->has(FormField::SINGLE_DATA_PARAM))
        {
            throw new \InvalidArgumentException(sprintf('Undefined [%s] param in request', FormField::SINGLE_DATA_PARAM));
        }

        $data = new Collection($request->get(FormField::SINGLE_DATA_PARAM));

        if (!$data->has('container_id') || !$data->has('container_type') || !$data->has('container_relation'))
        {
            throw new \InvalidArgumentException(sprintf('Invalid container data [%s] [%s] [%s]', $data->get('container_id', 'undefined'), $data->get('container_type', 'undefined'), $data->get('container_relation', 'undefined')));
        }

        $container_class = $data->get('container_type');
        $container = $container_class::findOrFail($data->get('container_id'));

        return $container;
    }

    public function detach(CrudRequest $request, $id)
    {
        if ($request->ajax() && $request->has('_section'))
        {
            $repository = $this->getRepository($this->getRepositoryParam($request));

            $this->setModel($repository->find($id));

            $container = $this->getContainer($request);

            $data = new Collection($request->get(FormField::SINGLE_DATA_PARAM));

            $container->detachContainee($data->get('container_relation'), $this->getModel());

            $container_controller = App::make($container->getControllerClass());
            $container_model_viewer_component = $container_controller->getModelViewerComponent($container);
            $template_name = sprintf('include.%s', $request->_section);

            return $this->response
                ->destroy($this->getModel()->getModelViewerComponent()->makeDomId($request->_section, md5(get_class($this->getModel())), $this->getModel()->id))
                ->get();
        }
    }

    protected function successResponse(CrudRequest $request, Repository $repository, AbstractCrudForm $form, CrudableModel $containee, $action)
    {
        if ($request->ajax() && $request->has('_section'))
        {
            $section_action_method = sprintf('handle%s%s', studly_case($request->get('_section')), studly_case($action));

            $this->$section_action_method($request, $repository, $form, $containee, $containee->getContainerElement($request));

            $form_component = (new CrudFormComponent())
                ->setForm($form)
                ->setRepository($this->getRepository());

            $model_viewer_component = $this->getModelViewerComponent($this->getModel());

            return $this->response
                ->append($form_component->getDomId('output'), (new Message())->fetch('crud.success'))
                ->modalClose($model_viewer_component->makeDomId(sprintf('modal-%s', $action)))
                ->get();
        }
        else
        {
            return parent::successResponse($request, $repository, $form, $containee, $action);
        }
    }

    protected function updateContaineeResponse(CrudRequest $request, Container $container)
    {
        $model_viewer_component = $this->getModelViewerComponent($this->getModel());
        $template_name = sprintf('include.%s', $request->_section);

        $this->response
            ->replace($model_viewer_component->makeDomId($request->_section, md5(get_class($this->getmodel())), $this->getModel()->id), $model_viewer_component->fetch($template_name, [
                'container' => $container,
            ]));

        return $this;
    }
}