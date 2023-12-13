<?php
namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService {

    private $domPdf;

    public function __construct() {
        $this->domPdf = new Dompdf();

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Garamond');
        $this->domPdf->setOptions($pdfOptions);
    }

    public function generatePdfFile($html, $outputFile) {
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        
        // Enregistrez le PDF sur le serveur
        $output = $this->domPdf->output();
        file_put_contents($outputFile, $output);

        return $outputFile;
    }
}
