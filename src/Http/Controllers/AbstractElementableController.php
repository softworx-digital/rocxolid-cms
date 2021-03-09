<?php

namespace Softworx\RocXolid\CMS\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid controllers
use Softworx\RocXolid\CMS\Http\Controllers\AbstractCrudController;
// rocXolid controller traits
use Softworx\RocXolid\Http\Controllers\Traits;
// rocXolid cms model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable;
// rocXolid cms components
use Softworx\RocXolid\CMS\Components\ModelViewers\ElementableModelViewer;
// rocXolid cms services
use Softworx\RocXolid\CMS\Services\ElementableCompositionService;

/**
 * CMS controller for models that can contain elements.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 * @todo return type hints
 */
abstract class AbstractElementableController extends AbstractCrudController
{
    use Traits\Utils\HasSectionResponse;

    /**
     * {@inheritDoc}
     */
    protected static $model_viewer_type = ElementableModelViewer::class;

    /**
     * {@inheritDoc}
     */
    protected $extra_services = [
        ElementableCompositionService::class,
    ];

    /**
     * Show snippets listing.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable $model
     */
    public function elementSnippets(CrudRequest $request, Elementable $model)
    {
        return $this->getModelViewerComponent($model)->render('snippets');
    }

    /**
     * Get content placeholders listing.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable $model
     */
    public function contentPlaceholders(CrudRequest $request, Elementable $model)
    {
        $model_viewer_component = $this->getModelViewerComponent($model);

        return $this->response
            ->modal($model_viewer_component->fetch('modal.content-placeholders'))
            ->get();
    }

    /**
     * Get content mutators listing.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable $model
     */
    public function contentMutators(CrudRequest $request, Elementable $model)
    {
        $model_viewer_component = $this->getModelViewerComponent($model);

        return $this->response
            ->modal($model_viewer_component->fetch('modal.content-mutators'))
            ->get();
    }

    /**
     * Store the elementable composition.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable $model
     */
    public function storeComposition(CrudRequest $request, Elementable $model)
    {
        $model = $this->elementableCompositionService()->compose($model, $this->validateCompositionData($request));

        return $this->successCompositionStoredResponse($request, $model);
    }

    /**
     * Detach element from elementable without deleting it from database.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable $model
     */
    public function detachElement(CrudRequest $request, Elementable $model)
    {
        dd(__METHOD__, '@todo');
    }

    /**
     * Delete element from elementable and database.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable $model
     */
    public function destroyElement(CrudRequest $request, Elementable $model)
    {
        $model = $this->elementableCompositionService()->destroyElement($model, $this->validateElementData($request));

        $model_viewer_component = $this->getModelViewerComponent($model);

        return $this->response->notifySuccess($model_viewer_component->translate('text.updated'))->get();
    }

    /**
     * Provide live preview from edited, not persisted content.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable $model
     */
    public function preview(CrudRequest $request, Elementable $model)
    {
        dd(__METHOD__, '@todo');
    }

    /**
     * Get the response for stored composition.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable $model
     */
    protected function successCompositionStoredResponse(CrudRequest $request, Elementable $model)
    {
        $model_viewer_component = $this->getModelViewerComponent($model);

        return $this->response
            ->notifySuccess($model_viewer_component->translate('text.updated'))
            ->redirect($this->getRoute('show', $model, [ 'tab' => 'composition' ])) // to reload with element ids for new elements
            ->get();
    }

    /**
     * Validate request data for composition manipulation actions.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @return \Illuminate\Support\Collection
     */
    protected function validateCompositionData(CrudRequest $request): Collection
    {
        // @todo extend to validate complete structure
        return collect($request->validate([
            'composition' => [
                'required',
                'array',
            ],
        ]));
    }

    /**
     * Validate request data for element manipulation actions.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @return \Illuminate\Support\Collection
     */
    protected function validateElementData(CrudRequest $request): Collection
    {
        // @todo extend to validate complete structure
        return collect($request->validate([
            'elementType' => [
                'required',
            ],
            'elementId' => [
                'required',
            ],
        ]));
    }
}
