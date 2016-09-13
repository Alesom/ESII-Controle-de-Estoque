<?php
require_once('tcpdf/tcpdf.php');

$pdf = new TCPDF( 'P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false );

$pdf->Output( 'teste.pdf', 'I' );

?>
