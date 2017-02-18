<?php
/*
Licença: MIT
Alunos: Alesom, André, Eduardo, Jardel, João Barp, Jovani e Kétly
Disciplina: Engenharia de Software II

Arquivo geraPDF:
é responsável gerar o relatório em PDF a partir do código html
*/
require_once( 'tcpdf/tcpdf.php' );
require_once( 'tcpdf/config/tcpdf_config.php' );
$ano = '';
$mes = '';
$dtin = '';
$dtfim = '';
$check = '';
if( isset( $_GET['check'] ) ) {
	$check = $_GET['check'];
    if( $check == 'anual' ) {
        if( isset( $_GET['ano'] ) ) {
            $ano = $_GET['ano'];
        } else {
            $ano = '2017'; // ano atual
        }
    } else if( $check == 'mensal' ) {
        if( isset( $_GET['ano'] ) ) {
            $ano = $_GET['ano'];
        } else {
            $ano = '';
        }
        if( isset( $_GET['mes'] ) ) {
            $mes = $_GET['mes'];
        } else {
            $mes = '';
        }
    } else if( $check == 'intervalo' ) {
        if( isset( $_GET['dataInicio'] ) ) {
            $dtin = $_GET['dataInicio'];
        } else {
            $dtin = '';
        }
        if( isset( $_GET['dataFim'] ) ) {
            $dtfim = $_GET['dataFim'];
        } else {
            $dtfim = '';
        }
    }
}
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

	private $data;
	private $tamanhoHeaderFonte = 15;
	private $nomeImagemHeader = 'IdentidadeVisual.png';
    private $texto = '';
    private $ano;
    private $mes;
    private $dtin;
    private $dtfim;
    private $check;
   function __construct( $data, $ano, $mes, $dtin, $dtfim, $check ) {
       parent::__construct( PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true );
	   $this->data = $data;
       $this->ano = $ano;
       $this->mes = $mes;
       $this->dtin = $dtin;
       $this->dtfim = $dtfim;
       $this->check = $check;
   }
    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.$this->nomeImagemHeader;
        if( file_exists($image_file) ) {
            $this->Image($image_file, 13, 10, 15, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
        }

        // Set font
        $this->SetFont('helvetica', 'B', $this->tamanhoHeaderFonte);
        // Title
        //$this->Cell(0, 15, '    Relatório  ('.$this->data.')', 0, false, '', 0, '', 0, false, 'T', 'B');

        switch( $this->check ) {
            case 'anual':
                $this->texto = 'Anual ('.$this->ano.')';
                break;
            case 'mensal':
                $this->texto = 'Mensal ('.$this->mes.'/'.$this->ano.')';
                break;
            case 'intervalo':
                $this->texto = '(de '.$this->dtin.' até '.$this->dtfim.')';
                break;
        }
        $this->Cell(0, 15, '    Relatório '.$this->texto, 0, false, '', 0, '', 0, false, 'T', 'B');
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
// Cria um PDF invocando o construtor
$pdf = new MYPDF( date( 'd/m/Y', time() ), $ano, $mes, $dtin, $dtfim, $check );
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
	$dados = $_GET['id'];
} else {
	$dados = "";
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
	</thead>'.$dados.'</table>';
$pdf->writeHTML( $table, true, false, false, false, '' );
// Define o nome do arquivo quando salvo ( "Relatorio" + "data_atual" )
$nome_pdf = 'Relatorio_'.date( 'd_m_Y', time());
// Exibe o PDF
// Opções comumente utilizadas:
//      I : Exibe o PDF no navegador normalmente
//      D : Força a exibição do diálogo para salvar o PDF imediatamente após sua criação
//      Outras opções: https://tcpdf.org/docs/source_docs/classTCPDF/#a3d6dcb62298ec9d42e9125ee2f5b23a1
$pdf->Output( $nome_pdf.'.pdf', 'I' );
?>
