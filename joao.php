<?php
include('phplot/phplot.php');
require('connect.php');

$codp = $_GET['codp'];
$nomep = $_GET['nomep'];
$codg = $_GET['codg'];
$nomeg = $_GET['nomeg'];
$codl = $_GET['codl'];
$nomel = $_GET['nomel'];
$dataI = $_GET['diai'];
$dataF = $_GET['diaf'];

if(isset($_GET['checkboxsaida'])){
$Saida = "SELECT p.nome AS nomep,p.cod as codp, sum(s.qtd) as soma FROM produto AS p
            INNER JOIN remocao AS s on (p.cod = s.codp)
            INNER JOIN grupo AS g on (p.codg = g.codg)
            INNER JOIN local AS l on (p.codl = l.codl)
            WHERE s.data between '$dataI' AND '$dataF' AND
            p.cod LIKE '%" . $codp . "%' AND p.nome LIKE '%" . $nomep . "%' AND g.codg LIKE '%" . $codg . "%'
      AND g.nome LIKE '%" . $nomeg . "%' AND l.codl LIKE '%" . $codl . "%' AND l.nome LIKE '%" . $nomel . "%'
      GROUP BY p.cod,p.nome";

      $i=0;
      $SaidaRes = query($conexao, $Saida) or die(mysql_error());
      $NSaidaRes = mysqli_num_rows($SaidaRes);
      $vetSAI;
      while ($resu = mysqli_fetch_assoc($SaidaRes)) {
        $vetSAI[$i]=array($resu['nomep'],$resu['codp'],$resu['soma']);
        $i++;
      }
}
if (isset($_GET['checkboxentrada'])){
$Entrada = "SELECT p.nome AS nomep,p.cod as codp, sum(s.qtd)as soma FROM produto AS p
            INNER JOIN insercao AS s on (p.cod = s.codp)
            INNER JOIN grupo AS g on (p.codg = g.codg)
            INNER JOIN local AS l on (p.codl = l.codl)
            WHERE s.data between '$dataI' AND '$dataF' AND
            p.cod LIKE '%" . $codp . "%' AND p.nome LIKE '%" . $nomep . "%' AND g.codg LIKE '%" . $codg . "%'
      AND g.nome LIKE '%" . $nomeg . "%' AND l.codl LIKE '%" . $codl . "%' AND l.nome LIKE '%" . $nomel . "%'
      GROUP BY p.cod,p.nome";

      $i=0;
      $EntradaRes = query($conexao, $Entrada) or die(mysql_error());
      $NEntradaRes = mysqli_num_rows($EntradaRes);
      $vetEN;
      while ($resu = mysqli_fetch_assoc($EntradaRes)) {
        $vetEN[$i]=array($resu['nomep'],$resu['codp'],$resu['soma']);
        $i++;
      }
}


$plot = new PHPlot(800,500);
$plot->SetPlotType('bars');
$plot->SetDataType('text-data');

  $i=0;
  $j=0;
  $x;
  $temp;
  $data;

  if(isset($_GET['checkboxentrada']) && isset($_GET['checkboxsaida'])){
    $i=0;
    $j=0;
    while ($i < $NEntradaRes) {
      $x=$vetEN[$i][1];
      while ($j < $NSaidaRes) {
        if($x == $vetSAI[$j][1]){
            $temp = $vetSAI[$j][2];
            break;
        }
        $j++;
      }
      $data[$i]=array($vetEN[$i][0],$vetEN[$i][2],$temp);
      $j=0;
      $temp=0;
      $i++;
    }
    $plot->SetLegend(array('Inseridos','Retirados'));
  }elseif (isset($_GET['checkboxentrada']) && !isset($_GET['checkboxsaida'])) {
    while ($i<$NEntradaRes) {
       $data[$i]=array($vetEN[$i][0],$vetEN[$i][2]);
       $i++;
    }
    $plot->SetLegend(array('Inseridos'));
  }elseif (!isset($_GET['checkboxentrada']) && isset($_GET['checkboxsaida'])) {
    while ($i<$NSaidaRes) {
       $data[$i]=array($vetSAI[$i][0],$vetSAI[$i][2]);
       $i++;
    }
    $plot->SetLegend(array('Retirados'));

  }


//$i=0;
//while($i<$NEntradaRes){
  // echo $data[$i][0]." ".$data[$i][1]." ".$data[$i][2]."</br>";
  // $i++;
//}


$plot->SetDataValues($data);
$plot->SetYDataLabelPos('plotin');
$plot->DrawGraph();
$plot->SetFileFormat("png");

?>
