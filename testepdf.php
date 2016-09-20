<?php
require_once( 'tcpdf/tcpdf.php' );
require_once( 'tcpdf/config/tcpdf_config.php' );

$pdf = new TCPDF( PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true );

// **************************************** CONFIGURAÇÃO INICIAL ************************************************* //

// Informações do documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('UFFS');
$pdf->SetTitle('Titulo');
$pdf->SetSubject('Assunto');
$pdf->SetKeywords('Palavras-chave');

// Dados do cabeçário
$pdf->SetHeaderData( PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING );

// Fonte utilizado do cabeçario e no rodapé
$pdf->setHeaderFont( Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN) );
$pdf->setFooterFont( Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA) );

// set default monospaced font
$pdf->SetDefaultMonospacedFont( PDF_FONT_MONOSPACED );

// Margens
$pdf->SetMargins( PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT );
$pdf->SetHeaderMargin( PDF_MARGIN_HEADER );
$pdf->SetFooterMargin( PDF_MARGIN_FOOTER );

// set auto page breaks
$pdf->SetAutoPageBreak( TRUE, PDF_MARGIN_BOTTOM );

// set image scale factor
$pdf->setImageScale( PDF_IMAGE_SCALE_RATIO );

// Fonte
$pdf->SetFont( 'helvetica', '', 10 );

// Adiciona uma página
$pdf->AddPage();


// **************************************************************************************************************** //


$table = <<<EOD
<table border="1" cellpadding="2" cellspacing="2" align="center">

	<tr nobr="true">
	  	<td bgcolor="#AAAAAA" style="font-size: 200%">Coluna 1</td>
	  	<td bgcolor="#AAAAAA" style="font-size: 200%">Coluna 2</td>
	  	<td bgcolor="#AAAAAA" style="font-size: 200%">Coluna 3</td>
	</tr>

	<tr nobr="true">
		<td>Alguma coisa X</td>
		<td>Alguma coisa X</td>
		<td>Alguma coisa X</td>
	 </tr>

	<tr nobr="true">
		<td>Alguma coisa Z</td>
		<td>Alguma coisa Z</td>
		<td>Alguma coisa Z</td>
	</tr>

	<tr nobr="true">
		<td>Alguma coisa Z</td>
		<td>Alguma coisa Z</td>
		<td>Alguma coisa Z</td>
	</tr>

	<tr nobr="true">
		<td>Alguma coisa Z</td>
		<td>Alguma coisa Z</td>
		<td>Alguma coisa Z</td>
	</tr>

	<tr nobr="true">
		<td>Alguma coisa Z</td>
		<td>Alguma coisa Z</td>
		<td>Alguma coisa Z</td>
	</tr>


</table>
EOD;

$pdf->writeHTML( $table, true, false, false, false, '' );

$pdf->Output( 'teste.pdf', 'I' );

?>
