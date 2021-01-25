<?php

namespace Softworx\RocXolid\CMS\Services;

// rocXolid pdf generator contracts
use Softworx\RocXolid\Generators\Pdf\Contracts\PdfGenerator;
use Softworx\RocXolid\Generators\Pdf\Contracts\PdfDataProvider;
// rocXolid service contracts
use Softworx\RocXolid\Services\Contracts\ConsumerService;
// rocXolid service traits
use Softworx\RocXolid\Services\Traits\HasServiceConsumer;

/**
 * Service to manipulate with page structures.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 * @todo currently this contains methods put away from WebFrontpageSettings model and controller
 */
class StructureService implements ConsumerService
{
    /*
    public $clone_log;

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

    public function destroyCmsStructure()
    {
        Page::make()->getAllPageElementModels()->each(function ($page_element_model, $short_kebab_name) {
            $this
                ->destroyClassObjects($page_element_model);
        });

        $this
            ->destroyClassObjects(Page::class)
            ->destroyClassObjects(PageProxy::class)
            ->destroyClassObjects(PageTemplate::class);

        return $this;
    }

    public function cloneCmsStructure(Web $web)
    {
        $this->clone_log = collect();

        Page::make()->getAllPageElementModels()->each(function ($page_element_model, $short_kebab_name) use ($web) {
            $this
                ->cloneClassObjects($page_element_model, $web);
        });

        $this
            ->cloneClassObjects(Page::class, $web)
            ->cloneClassObjects(PageProxy::class, $web)
            ->cloneClassObjects(PageTemplate::class, $web);

        return $this;
    }

    public function buildCmsStructure()
    {
        Page::make()->getAllPageElementModels()->each(function ($page_element_model, $short_kebab_name) {
            $this
                ->buildClassObjects($page_element_model);
        });

        $this
            ->buildClassObjects(Page::class)
            ->buildClassObjects(PageProxy::class)
            ->buildClassObjects(PageTemplate::class);

        return $this;
    }

    public function getCloningOutput()
    {
        return $this->cloning_output;
    }

    protected function destroyClassObjects($class)
    {
        $class::where('web_id', $this->web->getKey())->each(function ($object, $id) {
            $object->forceDelete();
        });

        return $this;
    }

    protected function cloneClassObjects($class, Web $web)
    {
        $class::where('web_id', $web->getKey())->each(function ($object, $id) {
            if ($object instanceof Cloneable) {
                $clone = $object->clone($this->clone_log, [
                    'web_id' => $this->web->getKey(),
                ]);
            }
        });

        return $this;
    }

    protected function buildClassObjects($class)
    {
        $class::where('web_id', $this->web->getKey())->each(function ($object, $id) {
            if ($object instanceof Cloneable) {
                $object->buildRelations($this->clone_log);
            }
        });

        return $this;
    }
    */
}
