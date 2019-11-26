<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\WebFrontpageSettings;

use Symfony\Component\HttpFoundation\Response;
use Softworx\RocXolid\Http\Requests\CrudRequest;
use Softworx\RocXolid\Forms\Contracts\FormField;
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as CrudModelViewerComponent;
use Softworx\RocXolid\Components\Forms\CrudForm as CrudFormComponent;
use Softworx\RocXolid\CMS\Components\ModelViewers\WebFrontpageSettingsViewer;
use Softworx\RocXolid\CMS\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\CMS\Repositories\WebFrontpageSettings\Repository;
use Softworx\RocXolid\CMS\Models\WebFrontpageSettings;
use Softworx\RocXolid\Common\Models\Web;

class Controller extends AbstractCrudController
{
    protected static $model_class = WebFrontpageSettings::class;

    protected static $repository_class = Repository::class;

    protected $form_mapping = [
        'create' => 'create',
        'store' => 'create',
        'edit' => 'update',
        'update' => 'update',
        'cloneStructure' => 'clone-structure',
        'cloneStructureSubmit' => 'clone-structure',
    ];

    public function getModelViewerComponent(CrudableModel $model): CrudModelViewerComponent
    {
        return WebFrontpageSettingsViewer::build($this, $this)
            ->setModel($model)
            ->setController($this);
    }

    public function cloneStructure(CrudRequest $request, WebFrontpageSettings $web_frontpage_settings)
    {
        $repository = $this->getRepository($this->getRepositoryParam($request));

        $this->setModel($web_frontpage_settings);

        $form = $repository->getForm($this->getFormParam($request));

        $form_component = CrudFormComponent::build($this, $this)
            ->setForm($form)
            ->setRepository($repository);

        $model_viewer_component = $this
            ->getModelViewerComponent($this->getModel())
            ->setFormComponent($form_component);

        if ($request->ajax())
        {
            return $this->response
                ->modal($model_viewer_component->fetch('modal.clone-structure'))
                ->get();
        }
        else
        {
            return false;
        }
    }

    public function cloneStructureSubmit(CrudRequest $request, WebFrontpageSettings $web_frontpage_settings)
    {
        $assignments = [];

        $repository = $this->getRepository($this->getRepositoryParam($request));

        $this->setModel($web_frontpage_settings);

        $form = $repository->getForm($this->getFormParam($request));
        $form
            //->adjustUpdate($request)
            ->adjustUpdateBeforeSubmit($request)
            ->submit();

        if ($form->isValid())
        {
            $web = Web::findOrFail($form->getFormField('web_id')->getValue());

            $form_component = CrudFormComponent::build($this, $this)
                ->setForm($form)
                ->setRepository($repository);

            $model_viewer_component = $this->getModelViewerComponent($web_frontpage_settings);

            $this->getModel()
                ->destroyCmsStructure()
                ->cloneCmsStructure($web)
                ->buildCmsStructure();

            $assignments = [
                'web' => $web,
                //'output' => $this->getModel()->getCloningOutput(),
            ];

            return $this->response
                    //->append($form_component->getDomId('output'), $model_viewer_component->fetch('output.clone-success', $assignments))
                    //->replace($model_viewer_component->getDomId('customer-note'), $model_viewer_component->fetch('include.customer-note', $assignments))
                    ->modalClose($model_viewer_component->getDomId('modal-clone-structure'))
                    ->modal($this->getModelViewerComponent($web_frontpage_settings)->fetch('modal.clone-structure-success', $assignments))
                    ->get();
        }
        else
        {
            return $this->errorResponse($request, $repository, $form, 'edit');
        }
    }
}