<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\Document;

use Illuminate\Validation\ValidationException;
// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
// rocXolid cms services
use Softworx\RocXolid\CMS\Services\ElementableCompositionService;
use Softworx\RocXolid\CMS\Services\PdfGeneratorService;
// rocXolid cms controllers
use Softworx\RocXolid\CMS\Http\Controllers\AbstractElementableController;
// rocXolid cms components
use Softworx\RocXolid\CMS\Components\ModelViewers\DocumentViewer;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\Document;
use Softworx\RocXolid\CMS\Models\DocumentHeader;
use Softworx\RocXolid\CMS\Models\DocumentFooter;
// rocXolid cms model forms
use Softworx\RocXolid\CMS\Models\Forms\Document\UpdateHeader;
use Softworx\RocXolid\CMS\Models\Forms\Document\UpdateFooter;

/**
 * Document controller.
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
    protected static $model_viewer_type = DocumentViewer::class;

    /**
     * {@inheritDoc}
     */
    protected $extra_services = [
        ElementableCompositionService::class,
        PdfGeneratorService::class,
    ];

    /**
     * {@inheritDoc}
     */
    protected $form_mapping = [
        'create' => 'create',
        'store' => 'create',
        'edit.general-data' => 'update-general',
        'update.general-data' => 'update-general',
        'edit.extended-data' => 'update-extended',
        'update.extended-data' => 'update-extended',
        'edit.description-data' => 'update-description',
        'update.description-data' => 'update-description',
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
            if ($form->getFormField('document_header_id')->isFieldValue(0)) {
                $header = $model->header;
                $model->header()->dissociate();

                if ($header->isBoundToDocument()) {
                    $header->forceDelete();
                }
            } else {
                $model->header()->associate(DocumentHeader::findOrFail($form->getFormField('document_header_id')->getFinalValue()));
            }
        }

        // @todo this doesn't belong here / find some other way
        if ($form instanceof UpdateFooter) {
            if ($form->getFormField('document_footer_id')->isFieldValue(0)) {
                $footer = $model->footer;
                $model->footer()->dissociate();

                if ($footer->isBoundToDocument()) {
                    $footer->forceDelete();
                }
            } else {
                $model->footer()->associate(DocumentFooter::findOrFail($form->getFormField('document_footer_id')->getFinalValue()));
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
                ->redirect($model->getControllerRoute('show'))
                ->get();
        }

        return $this->successUpdateResponse($request, $model, $form);
    }

    /**
     * Create PDF document and send it to response in base 64 encoding.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\CMS\Models\Document $document
     */
    public function previewPdf(CrudRequest $request, Document $document)
    {
        try {
            // $document = $this->elementableCompositionService()->composePreview($document, $this->validateCompositionData($request));
            // @todo temporary, not saving's causing troubles right now
            $document = $this->elementableCompositionService()->compose($document, $this->validateCompositionData($request));

            $html = $document->getModelViewerComponent()->setViewTheme($document->theme)->fetch('default');

            $pdf = $this->pdfGeneratorService()->generatePdf($document, $html);

            return $this->response
                ->file64($pdf)//, 'sample.pdf') // provided name triggers download dialog
                ->get();
        } catch (ValidationException $e) {
            return $this->response
                ->notifyError($e->getMessage())
                ->get();
        } catch (\Exception $e) {
            return $this->response
                ->notifyError($e->getMessage())
                ->get();
        }
    }
}
