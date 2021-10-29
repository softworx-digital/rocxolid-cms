<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\Page;

// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
// rocXolid cms controllers
use Softworx\RocXolid\CMS\Http\Controllers\AbstractElementableController;
// rocXolid cms components
use Softworx\RocXolid\CMS\Components\ModelViewers\Page as PageModelViewer;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\PageHeader;
use Softworx\RocXolid\CMS\Models\PageFooter;
// rocXolid cms model forms
use Softworx\RocXolid\CMS\Models\Forms\Page\UpdateHeader;
use Softworx\RocXolid\CMS\Models\Forms\Page\UpdateFooter;

/**
 * CMS Page controller.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class Controller extends AbstractElementableController
{
    /**
     * {@inheritDoc}
     */
    protected static $model_viewer_type = PageModelViewer::class;

    /**
     * {@inheritDoc}
     */
    protected $form_mapping = [
        'create' => 'create',
        'store' => 'create',
        //
        'edit.panel.data.general' => 'update-general-data',
        'update.panel.data.general' => 'update-general-data',
        //
        'edit.panel.data.meta' => 'update-meta-data',
        'update.panel.data.meta' => 'update-meta-data',
        //
        'edit.panel:extended.data.extended' => 'update-extended-data',
        'update.panel:extended.data.extended' => 'update-extended-data',
        //
        'edit.perex-data' => 'update-perex',
        'update.perex-data' => 'update-perex',
        'edit.content-data' => 'update-content',
        'update.content-data' => 'update-content',
        //
        'edit.header' => 'update-header',
        'edit.update' => 'update-header',
        'edit.footer' => 'update-footer',
        'edit.footer' => 'update-footer',
    ];

    /**
     * {@inheritDoc}
     */
    protected function onUpdateFormValid(CrudRequest $request, CrudableModel $model, AbstractCrudForm $form)//: Response
    {
        // @todo this doesn't belong here / find some other way
        if ($form instanceof UpdateHeader) {
            if ($form->getFormField('page_header_id')->isFieldValue(0)) {
                $header = $model->header;
                $model->header()->dissociate();

                if ($header->isBoundToPage()) {
                    $header->forceDelete();
                }
            } else {
                $model->header()->associate(PageHeader::findOrFail($form->getFormField('page_header_id')->getFinalValue()));
            }
        }

        // @todo this doesn't belong here / find some other way
        if ($form instanceof UpdateFooter) {
            if ($form->getFormField('page_footer_id')->isFieldValue(0)) {
                $footer = $model->footer;
                $model->footer()->dissociate();

                if ($footer->isBoundToPage()) {
                    $footer->forceDelete();
                }
            } else {
                $model->footer()->associate(PageFooter::findOrFail($form->getFormField('page_footer_id')->getFinalValue()));
            }
        }

        return parent::onUpdateFormValid($request, $model, $form);
    }

    /**
     * {@inheritDoc}
     */
    protected function onModelUpdatedSuccessResponse(CrudRequest $request, CrudableModel $model, AbstractCrudForm $form)//: Response
    {
        if (($form instanceof UpdateHeader) || ($form instanceof UpdateFooter)) {
            $model_viewer_component = $this->getModelViewerComponent($model);

            return $this->response
                ->notifySuccess($model_viewer_component->translate('text.updated'))
                ->modalClose($model_viewer_component->getDomId(sprintf('modal-%s', $form->getParam())))
                ->redirect($model->getControllerRoute('show', [ 'tab' => 'composition' ]))
                ->get();
        }

        return $this->successUpdateResponse($request, $model, $form);
    }
}
