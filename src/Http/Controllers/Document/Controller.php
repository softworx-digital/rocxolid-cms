<?php

namespace Softworx\RocXolid\CMS\Http\Controllers\Document;

use Illuminate\Validation\ValidationException;
// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid cms services
use Softworx\RocXolid\CMS\Services\ElementableCompositionService;
use Softworx\RocXolid\CMS\Services\PdfGeneratorService;
// rocXolid cms controllers
use Softworx\RocXolid\CMS\Http\Controllers\AbstractElementableController;
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
class Controller extends AbstractElementableController
{
    protected static $model_viewer_type = DocumentViewer::class;

    protected $extra_services = [
        ElementableCompositionService::class,
        PdfGeneratorService::class,
    ];

    public function previewPdf(CrudRequest $request, Document $document)
    {
        try {
            $data = $request->validate([
                'content' => 'required',
            ]);

            $pdf = $this->pdfGeneratorService()->generatePdf($this->getDashboard(), $document, collect($data));

            return $this->response
                    ->file64($pdf)//, 'sample.pdf')
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
