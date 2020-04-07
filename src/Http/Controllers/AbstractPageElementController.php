<?php

namespace Softworx\RocXolid\CMS\Http\Controllers;

// @todo - upratat
use App;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Softworx\RocXolid\Http\Requests\FormRequest;
use Softworx\RocXolid\Http\Requests\CrudRequest;
use Softworx\RocXolid\Http\Controllers\Contracts\Crudable as CrudableController;
use Softworx\RocXolid\Forms\Contracts\FormField;
use Softworx\RocXolid\Forms\AbstractCrudForm;
use Softworx\RocXolid\Components\Forms\CrudForm as CrudFormComponent;
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
use Softworx\RocXolid\Repositories\Contracts\Repository;
use Softworx\RocXolid\CMS\Http\Controllers\AbstractCrudController as AbstractCMSController;
use Softworx\RocXolid\CMS\Models\Contracts\PageElementable;
use Softworx\RocXolid\CMS\Models\PageTemplate;
use Softworx\RocXolid\CMS\Models\Page;
use Softworx\RocXolid\CMS\Models\PageProxy;
use Softworx\RocXolid\CMS\Models\Article;

// @todo - cele refactornut - vzhladom na pagelementable a pageelementy, ktore mozu mat v sebe elementy (containery)
abstract class AbstractPageElementController extends AbstractCMSController
{
    protected $form_mapping = [
        'create' => 'create',
        'store' => 'create',
        'edit' => 'update',
        'update' => 'update',
        'create.page-elements' => 'create-in-page-elementable',
        'store.page-elements' => 'create-in-page-elementable',
        'edit.page-elements' => 'update-in-page-elementable',
        'update.page-elements' => 'update-in-page-elementable',
    ];

    // @todo - zrejme posielat aj classu + test na interface po find instancie a neifovat to - skarede
    // vid AbstractPageElementProxyController, kde sa overrideuje
    public function getPageElementable(FormRequest $request): PageElementable
    {
        if (!$request->has(FormField::SINGLE_DATA_PARAM)) {
            throw new \InvalidArgumentException(sprintf('Undefined [%s] param in request', FormField::SINGLE_DATA_PARAM));
        }

        $data = collect($request->get(FormField::SINGLE_DATA_PARAM));

        if ($data->has('_page_template_id')) {
            $page_elementable = PageTemplate::findOrFail($data->get('_page_template_id'));
        } elseif ($data->has('_page_proxy_id')) {
            $page_elementable = PageProxy::findOrFail($data->get('_page_proxy_id'));
        } elseif ($data->has('_page_id')) {
            $page_elementable = Page::findOrFail($data->get('_page_id'));
        } elseif ($data->has('_article_id')) {
            $page_elementable = Article::findOrFail($data->get('_article_id'));
        }

        if (!isset($page_elementable)) {
            throw new \InvalidArgumentException(sprintf('Undefined _page_template_id or _page_proxy_id or _page_id in request or _article_id'));
        }

        return $page_elementable;
    }

    public function detach(CrudRequest $request, $id)
    {
        if (!$request->has('_section'))
        {
            throw new \InvalidArgumentException('Missing [_section] param in request');
        }

        $model = $this->getRepository()->find($id);

        $page_elementable = $this->getPageElementable($request);
        $page_elementable->detachPageElement($model);

        $page_elementable_controller = $page_elementable->getCrudController();
        $page_elementable_model_viewer_component = $page_elementable_controller->getModelViewerComponent($page_elementable);
        $template_name = sprintf('include.%s', $request->_section);

        return $this->response
            ->replace($page_elementable_model_viewer_component->getDomId($request->_section, $page_elementable->getKey()), $page_elementable_model_viewer_component->fetch($template_name))
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    protected function onModelUpdated(CrudRequest $request, CrudableModel $page_element, AbstractCrudForm $form): CrudableController
    {
        if (!$request->has('_section'))
        {
            throw new \InvalidArgumentException('Missing [_section] param in request');
        }

        $section_action_method = sprintf('handle%s%s', Str::studly($request->get('_section')), Str::studly($form->getParam()));

        if (!method_exists($this, $section_action_method))
        {
            throw new \RuntimeException(sprintf('Invalid method call [%s] in [%s]', $section_action_method, get_class($this)));
        }

        $this->$section_action_method($request, $repository, $form, $page_element, $this->getPageElementable($request));
    }

    protected function handlePageElementsCreate(CrudRequest $request, AbstractCrudForm $form, CrudableModel $page_element, PageElementable $page_elementable)
    {
        $page_elementable->addPageElement($page_element);

        return $this->updatePageElementableResponse($request, $page_elementable);
    }

    protected function handlePageElementsUpdate(CrudRequest $request, AbstractCrudForm $form, CrudableModel $page_element, PageElementable $page_elementable)
    {
        return $this->updatePageElementableResponse($request, $page_elementable);
    }

    protected function handlePageElementsDetach(CrudRequest $request, AbstractCrudForm $form, CrudableModel $page_element, PageElementable $page_elementable)
    {
        return $this;
    }

    protected function updatePageElementableResponse(CrudRequest $request, PageElementable $page_elementable)
    {
        $page_elementable_controller = $page_elementable->getCrudController();
        $page_elementable_model_viewer_component = $page_elementable_controller->getModelViewerComponent($page_elementable);
        $template_name = sprintf('include.%s', $request->_section);

        return $this->response->redirect($page_elementable->getControllerRoute('show'))->get();
        /*
        $this->response
            ->replace($page_elementable_model_viewer_component->getDomId($request->_section, $page_elementable->getKey()), $page_elementable_model_viewer_component->fetch($template_name));

        return $this;
        */
    }
}
