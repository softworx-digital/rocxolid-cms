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
use Softworx\RocXolid\CMS\Models\WebFrontpageSettings;
use Softworx\RocXolid\Common\Models\Web;

class Controller extends AbstractCrudController
{
    protected static $model_viewer_type = WebFrontpageSettingsViewer::class;

    protected $form_mapping = [
        'create' => 'create',
        'store' => 'create',
        'edit' => 'update',
        'update' => 'update',
        'cloneStructure' => 'clone-structure',
        'cloneStructureSubmit' => 'clone-structure',
    ];

    public function cloneStructure(CrudRequest $request, WebFrontpageSettings $web_frontpage_settings)
    {
        $form = $this->getForm($request, $web_frontpage_settings);

        $model_viewer_component = $this->getModelViewerComponent(
            $web_frontpage_settings,
            $this->getFormComponent($form)
        );

        return $this->response
            ->modal($model_viewer_component->fetch('modal.clone-structure'))
            ->get();
    }

    public function cloneStructureSubmit(CrudRequest $request, WebFrontpageSettings $web_frontpage_settings)
    {
        $form = $this
            ->getForm($request, $web_frontpage_settings)
            ->submit();

        if ($form->isValid()) {
            $web = Web::findOrFail($form->getFormField('web_id')->getValue());

            $model_viewer_component = $this->getModelViewerComponent(
                $web_frontpage_settings,
                $this->getFormComponent($form)
            );

            $model = $this->getRepository()->getModel();

            $model
                ->destroyCmsStructure()
                ->cloneCmsStructure($web)
                ->buildCmsStructure();

            return $this->response
                    //->append($form_component->getDomId('output'), $model_viewer_component->fetch('output.clone-success', $assignments))
                    //->replace($model_viewer_component->getDomId('customer-note'), $model_viewer_component->fetch('include.customer-note', $assignments))
                    ->modalClose($model_viewer_component->getDomId('modal-clone-structure'))
                    ->modal($this->getModelViewerComponent($web_frontpage_settings)->fetch('modal.clone-structure-success', [
                        'web' => $web,
                        //'output' => $model->getCloningOutput(),
                    ]))
                    ->get();
        } else {
            return $this->errorResponse($request, $this->getRepository()->getModel(), $form, 'edit');
        }
    }
}
