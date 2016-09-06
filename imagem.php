<?php
#incluindo a classe. verifique se diretorio e versao sao iguais, altere se precisar
include('phplot/phplot.php');
require('connect.php');
#Matriz utilizada para gerar os graficos
$data = array(
array('Jan', 20, 2, 4), array('Fev', 30, 3, 4), array('Mar', 20, 4, 14),
array('Abr', 30, 5, 4), array('Mai', 13, 6, 4), array('Jun', 37, 7, 24),
array('Jul', 10, 8, 4), array('Ago', 15, 9, 4), array('Set', 20, 5, 12),
array('Out', 28, 4, 14), array('Nov', 16, 7, 14), array('Dez', 24, 3, 15),
);

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
$plot->SetPlotType('bars');
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
