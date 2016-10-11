<?php
#incluindo a classe. verifique se diretorio e versao sao iguais, altere se precisar
include('phplot/phplot.php');
require('connect.php');
#Matriz utilizada para gerar os graficos

	switch($_GET['periodo']){
		case 'anual':
			$datai="".$_GET['ano']."-01-01 00:00:00";
			$dataf="".$_GET['ano']."-12-31 23:59:59";
			break;
		case 'mensal':
			switch($_GET['mes']){
				case 'jan':
					$mes = "01";
					break;
				case 'fev':
					$mes = "02";
					break;
				case 'mar':
					$mes = "03";
					break;
				case 'abr':
					$mes = "04";
					break;
				case 'mai':
					$mes = "05";
					break;
				case 'jun':
					$mes = "06";
					break;
				case 'jul':
					$mes = "07";
					break;
				case 'ago':
					$mes = "08";
					break;
				case 'set':
					$mes = "09";
					break;
				case 'out':
					$mes = "10";
					break;
				case 'nov':
					$mes = "11";
					break;
				case 'dez':
					$mes = "12";
					break;
			}
			$datai=$_GET['ano'].'-'.$mes."-01 00:00:00";
			$dataf=$_GET['ano'].'-'.$mes."-31 23:59:59";
			break;
		case 'intervalo':
			$datai=$_GET['datai'];
			$dataf=$_GET['dataf'];
			break;
	}

	$codp=$_GET['codp'];

	$query1="SELECT * FROM produto p join insercao i on p.cod=i.codp WHERE p.cod = '$codp' AND i.data between '$datai' AND '$dataf'";
	$query2="SELECT * FROM produto p join remocao r on r.codp=p.cod WHERE p.cod = '$codp' AND r.data between '$datai' AND '$dataf' ";

	echo $codp. "<br/>".$datai. "<br/>".$dataf;
	//$res1 = mysqli_query($conexao,$query1);
	//if($res1)
	echo	 "ola";
	$res1= query($conexao, $query1);
	while ($resu = mysqli_fetch_assoc($res1)){
		$data1[$a]= array($resu['qtd'],$resu['data']);
		//echo $data1[$b][$a];
		$a++;
	}

	$res2= query($conexao, $query2);
	//$res2 = mysqli_query($conexao,$query2);
	$a=0;
	$b=0;

	while ($resu1 = mysqli_fetch_assoc($res2)){
		$data1[$a]= array($resu1['data'],$resu1['qtd']);
		//echo $data1[$b][$a];
		$a++;
		//$b++;
	}

/*
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
	}*/


#Instancia o objeto e setando o tamanho do grafico na tela
$plot = new PHPlot(800,500);
#Tipo de borda, consulte a documentacao
$plot->SetImageBorderType('none');
#Tipo de grafico, nesse caso barras, existem diversos(pizza…)
if(isset($_GET["type"])){
	switch ($_GET["type"]){
	case 'Barra':
		$plot->SetPlotType('bars');
		break;
	case 'Pizza':
		$plot->SetPlotType('pie');
		break;
	case 'Bolha':
		$plot->SetPlotType('bubbles');
		break;
	case 'Pontos':
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
$plot->SetLegend(array('Disponivel','Retiradas','Inseridos','naofacoideia'));
#Utilizados p/ marcar labels, necessario mas nao se aplica neste ex. (manual) :
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');
#Gera o grafico na tela
//$plot->DrawGraph();
?>
