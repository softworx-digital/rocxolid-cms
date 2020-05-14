<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\Document;

use Illuminate\Validation\ValidationException;
// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid cms services
use Softworx\RocXolid\CMS\Services\ElementableCompositionService;
use Softworx\RocXolid\CMS\Services\PdfGeneratorService;
// rocXolid cms controllers
use Softworx\RocXolid\CMS\Http\Controllers\AbstractDocumentController;
// rocXolid cms components
use Softworx\RocXolid\CMS\Components\ModelViewers\DocumentViewer;
// rocXolid models
use Softworx\RocXolid\CMS\Models\Document;

/**
 * Document controller.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class Controller extends AbstractDocumentController
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
     * Create PDF document and send it to response in base 64 encoding.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\CMS\Models\Document $document
     */
    public function previewPdf(CrudRequest $request, Document $document)
    {
        try {
            // $document = $this->elementableCompositionService()->composePreview($document, $this->validateCompositionData($request));
            // @todo: temporary, not saving's causing troubles right now
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
