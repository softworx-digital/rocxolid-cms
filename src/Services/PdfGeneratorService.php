<?php

namespace Softworx\RocXolid\CMS\Services;

use View;
use Spipu\Html2Pdf\Html2Pdf;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
// rocXolid service contracts
use Softworx\RocXolid\Services\Contracts\ConsumerService;
// rocXolid service contracts
use Softworx\RocXolid\Contracts\ServiceConsumer;
// rocXolid models
use Softworx\RocXolid\CMS\Models\Document;

/**
 * Service to generate PDF files.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid
 * @version 1.0.0
 */
class PdfGeneratorService implements ConsumerService
{
    protected $consumer;

    /**
     * {@inheritDoc}
     */
    public function setConsumer(ServiceConsumer $consumer): ConsumerService
    {
        $this->consumer = $consumer;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function generatePdf($dashbpard, Document $document, Collection $data)
    {
        $view = View::make('rocXolid::pdf', [
            'content' => $data->get('content')
        ]);

        // $html2pdf = new Html2Pdf('P', 'A4', 'en', true, 'UTF-8', array(5, 5, 5, 5));
        $html2pdf = new Html2Pdf('P', 'A4', 'en', true, 'UTF-8', [ 0, 0, 0, 0 ]);
        // $html2pdf->writeHTML($data->get('content'));
        $html2pdf->writeHTML($view->render());
        // $html2pdf->writeHTML('<page><h1>HelloWorld</h1>This is my first page</page>');


        $pdf = $html2pdf->output('abc.pdf', 'S');

        // Storage::put('_delete/test.pdf', $pdf);

        return $pdf;
    }
}
