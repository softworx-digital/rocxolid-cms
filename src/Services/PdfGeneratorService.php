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
 * Service to generate PDF files.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid
 * @version 1.0.0
 */
class PdfGeneratorService implements ConsumerService
{
    use HasServiceConsumer;

    /**
     * PDF generator reference.
     *
     * @var \Softworx\RocXolid\Generators\Pdf\Contracts\PdfGenerator
     */
    protected $pdf_generator;

    /**
     * Constructor.
     *
     * @param \Softworx\RocXolid\Generators\Pdf\Contracts\PdfGenerator $pdf_generator
     */
    public function __construct(PdfGenerator $pdf_generator)
    {
        $this->pdf_generator = $pdf_generator;
    }

    /**
     * Generate PDF content.
     *
     * @param \Softworx\RocXolid\Generators\Pdf\Contracts\PdfDataProvider $provider
     * @param string $html
     * @return string
     */
    public function generatePdf(PdfDataProvider $provider, string $html)
    {
        $pdf = $this->pdf_generator
            ->init()
            ->setContent($html)
            ->generate($provider);

        return $pdf;
    }
}
