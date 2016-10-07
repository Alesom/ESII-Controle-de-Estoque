<?php
require_once( 'tcpdf/tcpdf.php' );
require_once( 'tcpdf/config/tcpdf_config.php' );

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

	private $data;
	private $tamanhoHeaderFonte = 15;
	private $nomeImagemHeader = 'IdentidadeVisual.png';	

   function __construct( $data ) {
       parent::__construct( PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true );  
	   $this->data = $data;     
   }

    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.$this->nomeImagemHeader;
        $this->Image($image_file, 13, 10, 15, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', $this->tamanhoHeaderFonte);
        // Title
        $this->Cell(0, 15, '    Relatório  ('.$this->data.')', 0, false, '', 0, '', 0, false, '', '');		
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new MYPDF( date( 'd/m/Y', time() ) );

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

//$pdf->SetPrintHeader(false);
//$pdf->SetPrintFooter(false);

// set auto page breaks
$pdf->SetAutoPageBreak( TRUE, PDF_MARGIN_BOTTOM );

// set image scale factor
$pdf->setImageScale( PDF_IMAGE_SCALE_RATIO );

// Fonte
$pdf->SetFont( 'helvetica', '', 10 );

// Adiciona uma página
$pdf->AddPage();


// **************************************************************************************************************** //

if( isset( $_GET['id'] ) ) {
	$teste = $_GET['id'];
} else {
	$teste = "erro";
}

$table = '<table border="1" cellpadding="2" cellspacing="2" align="center">
<thead>
		<tr>
			<td><center><b>Código</b></center></td>
			<td><center><b>Nome</b></center></td>
			<td><center><b>Quantidade</b></center></td>
			<td><center><b>Grupo</b></center></td>
			<td><center><b>Local</b></center></td>
			<td><center><b>Data de Entrada</b></center></td>
			<td><center><b>Data de Saída</b></center></td>
		</tr>
	</thead>'.$teste.'</table>';

$pdf->writeHTML( $table, true, false, false, false, '' );

$pdf->Output( 'teste.pdf', 'I' );

?>
