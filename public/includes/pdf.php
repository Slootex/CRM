<?php
use setasign\Fpdi;

$parser = 'fpdi-pdf-parser';
$filename = '5274.pdf';

require_once('fpdf/fpdf.php');
require_once('fpdi2/src/autoload.php');
require_once('fpdi_pdf-parser2/src/autoload.php');

// overwrite FPDI to define which parser should be used.
class Pdf extends Fpdi\Fpdi
{
    /**
     * @var string
     */
    protected $pdfParserClass = null;

    /**
     * Set the pdf reader class.
     *
     * @param string $pdfParserClass
     */
    public function setPdfParserClass($pdfParserClass)
    {
        $this->pdfParserClass = $pdfParserClass;
    }

    /**
     * Get a new pdf parser instance.
     *
     * @param Fpdi\PdfParser\StreamReader $streamReader
     * @return Fpdi\PdfParser\PdfParser|setasign\FpdiPdfParser\PdfParser\PdfParser
     */
    protected function getPdfParserInstance(Fpdi\PdfParser\StreamReader $streamReader)
    {
        if ($this->pdfParserClass !== null) {
            return new $this->pdfParserClass($streamReader);
        }

        return parent::getPdfParserInstance($streamReader);
    }

    /**
     * Checks what kind of cross-reference parser is used.
     *
     * @return string
     */
    public function getXrefInfo()
    {
        foreach (array_keys($this->readers) as $readerId) {
            $crossReference = $this->getPdfReader($readerId)->getParser()->getCrossReference();
            $readers = $crossReference->getReaders();
            
        }

        return 'normal';
    }
}