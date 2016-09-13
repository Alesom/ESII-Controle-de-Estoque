<?php
#incluindo a classe. verifique se diretorio e versao sao iguais, altere se precisar
include('phplot/phplot.php');
require('connect.php');
#Matriz utilizada para gerar os graficos
	$data1;
	$a=0;
	$sql = "SELECT * FROM produto";
	$res = mysqli_query($conexao,$sql);
	while ($resu = mysqli_fetch_assoc($res)){
		$b= $resu['cod'];
		$sql1 = "SELECT SUM(qtd) as soma FROM remocao where codp='$b'";
		$sql2 = "SELECT SUM(qtd) as soma FROM insercao where codp='$b'";
		$res1 = mysqli_query($conexao,$sql1);
		$res2 = mysqli_query($conexao,$sql2);
		$resu1 = mysqli_fetch_assoc($res1);
		$resu2 = mysqli_fetch_assoc($res2);
		$data1[$a]	= array($resu['nome'],$resu['qtd'],$resu1['soma'],$resu2['soma']);
		$a++;
	}

#Instancia o objeto e setando o tamanho do grafico na tela
$plot = new PHPlot(800,500);
#Tipo de borda, consulte a documentacao
$plot->SetImageBorderType('none');
#Tipo de grafico, nesse caso barras, existem diversos(pizza…)
if(isset($_GET["type"])){
	switch ($_GET["type"]){
	case 'barra':
		$plot->SetPlotType('bars');
		break;
	case 'pizza':
		$plot->SetPlotType('pie');
		break;
	case 'bolha':
		$plot->SetPlotType('bubbles');
		break;
	case 'pontos':
		$plot->SetPlotType('linepoints');
		break;
	}
}	
#Tipo de dados, nesse caso texto que esta no array
$plot->SetDataType('text-data');
#Setando os valores com os dados do array
$plot->SetDataValues($data1);
#Titulo do grafico
$plot->SetTitle('Produtos');
#Legenda, nesse caso serao tres pq o array possui 3 valores que serao apresentados
$plot->SetLegend(array('Disponivel','Retiradas','Inseridos'));
#Utilizados p/ marcar labels, necessario mas nao se aplica neste ex. (manual) :
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');
#Gera o grafico na tela
$plot->DrawGraph();
$plot->SetFileFormat("png");
?>
