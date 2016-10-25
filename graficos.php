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

  $vetSAI;
  $vetEN;
  $NSaidaRes;
  $NEntradaRes;

  if($_GET['saida'] == 1){
    $Saida = "SELECT p.nome AS nomep, sum(s.qtd) as soma
              FROM produto AS p
              INNER JOIN remocao AS s on (p.cod = s.codp)
              INNER JOIN grupo AS g on (p.codg = g.codg)
              INNER JOIN local AS l on (p.codl = l.codl)
              WHERE s.data between ('" . $dataI . "') AND ('" . $dataF . "') AND
              p.cod LIKE '%" . $codp . "%' AND p.nome LIKE '%" . $nomep . "%' AND g.codg LIKE '%" . $codg . "%'
              AND g.nome LIKE '%" . $nomeg . "%' AND l.codl LIKE '%" . $codl . "%' AND l.nome LIKE '%" . $nomel . "%'
              GROUP BY p.nome";
    $i=0;
    $SaidaRes = query($conexao, $Saida) or die(mysql_error());
    $NSaidaRes = mysqli_num_rows($SaidaRes);
    $vetSAI;
    while ($resu = mysqli_fetch_assoc($SaidaRes)) {
      $vetSAI[$i]=array($resu['nomep'], $resu['soma']);
      $i++;
    }
  }

  if ($_GET['entrada'] == 1){
    $Entrada = "SELECT p.nome AS nomep, sum(s.qtd) as soma
                FROM produto AS p
                INNER JOIN insercao AS s on (p.cod = s.codp)
                INNER JOIN grupo AS g on (p.codg = g.codg)
                INNER JOIN local AS l on (p.codl = l.codl)
                WHERE s.data between ('" . $dataI . "') AND ('" . $dataF . "') AND
                p.cod LIKE '%" . $codp . "%' AND p.nome LIKE '%" . $nomep . "%' AND g.codg LIKE '%" . $codg . "%'
                AND g.nome LIKE '%" . $nomeg . "%' AND l.codl LIKE '%" . $codl . "%' AND l.nome LIKE '%" . $nomel . "%'
                GROUP BY p.nome";
    $i=0;
    $EntradaRes = query($conexao, $Entrada) or die(mysql_error());
    $NEntradaRes = mysqli_num_rows($EntradaRes);
    $vetEN;
    while ($resu = mysqli_fetch_assoc($EntradaRes)) {
      $vetEN[$i]=array($resu['nomep'], $resu['soma']);
      $i++;
    }
  }

  $i=0;
  $j=0;
  $x;
  $temp;
  $data = array();
  $plot = new PHPlot(800,500);

  if($_GET['entrada'] == 1 && $_GET['saida'] == 1){
    $i=0;
    $j=0;
    if($NEntradaRes > 0 && $NSaidaRes > 0){
      while ($i < $NEntradaRes) {
        $x=$vetEN[$i][0];
        while ($j < $NSaidaRes) {
          if($x == $vetSAI[$j][0]){
            $temp = $vetSAI[$j][1];
            break;
          }
          $j++;
        }
        $data[$i]=array($vetEN[$i][0], $vetEN[$i][1], $temp);
        $j=0;
        $temp=0;
        $i++;
      }
      $plot->SetLegend(array('Inseridos','Retirados'));
    }else if ($NEntradaRes > 0 && $NSaidaRes == 0) {
      while ($i<$NEntradaRes) {
        $data[$i]=array($vetEN[$i][0],$vetEN[$i][1]);
        $i++;
      }
      $plot->SetLegend(array('Inseridos'));
    }else if ($NEntradaRes == 0 && $NSaidaRes > 0) {
      while ($i<$NSaidaRes) {
        $data[$i]=array($vetSAI[$i][0],$vetSAI[$i][1]);
        $i++;
      }
      $plot->SetLegend(array('Retirados'));
    }
  }else if ($_GET['entrada'] == 1) {
    while ($i<$NEntradaRes) {
       $data[$i]=array($vetEN[$i][0],$vetEN[$i][1]);
       $i++;
    }
    $plot->SetLegend(array('Inseridos'));
  }else if ($_GET['saida'] == 1) {
    while ($i<$NSaidaRes) {
       $data[$i]=array($vetSAI[$i][0],$vetSAI[$i][1]);
       $i++;
    }
    $plot->SetLegend(array('Retirados'));
  }

  if (empty($data)) {
    echo 'NENHUM DADO ENCONTRADO!';
  } else {
    $plot->SetPlotType('bars');
    $plot->SetDataType('text-data');
    $plot->SetDataValues($data);
    $plot->SetYDataLabelPos('plotin');
    $plot->DrawGraph();
    $plot->SetFileFormat("png");
  }
?>
