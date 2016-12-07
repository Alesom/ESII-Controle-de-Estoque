<?php
	require ("connect.php");

	$codp = $_GET['codp'];
	$nomep = $_GET['nomep'];
	$codg = $_GET['codg'];
	$nomeg = $_GET['nomeg'];
	$codl = $_GET['codl'];
	$nomel = $_GET['nomel'];
	$dataI = $_GET['diai'];
	$dataF = $_GET['diaf'];
	$saidaF = $_GET['saida'];
	$entradaF = $_GET['entrada'];

	$Saida = "SELECT p.cod AS codp, p.nome AS nomep, s.qtd AS qtd, g.nome
							AS nomeg, l.nome AS nomel, s.data AS datas, s.codp AS scodp
							FROM produto AS p INNER JOIN remocao AS s on (p.cod = s.codp)
							INNER JOIN localizacao AS lz on (p.cod = lz.codp)
							INNER JOIN grupo AS g on (SUBSTRING(p.cod,1,1) = g.codg)
							INNER JOIN local AS l on (l.codl = lz.codl)
							WHERE s.data between '$dataI' AND '$dataF' AND
							p.cod LIKE '%" . $codp . "%' AND p.nome LIKE '%" . $nomep . "%' AND g.codg LIKE '%" . $codg . "%'
				AND g.nome LIKE '%" . $nomeg . "%' AND l.codl LIKE '%" . $codl . "%' AND l.nome LIKE '%" . $nomel . "%'
				ORDER BY s.data";

	$Entrada = "SELECT p.cod AS codp, p.nome AS nomep, e.qtd AS qtd, g.nome
							AS nomeg, l.nome AS nomel, e.data AS datae, e.codp AS ecodp
							FROM produto AS p INNER JOIN insercao AS e on (p.cod = e.codp)
							INNER JOIN localizacao AS lz on (p.cod = lz.codp)
							INNER JOIN grupo AS g on (SUBSTRING(p.cod,1,1) = g.codg)
							INNER JOIN local AS l on (l.codl = lz.codl)
							WHERE e.data between '$dataI' AND '$dataF' AND
							p.cod LIKE '%" . $codp . "%' AND p.nome LIKE '%" . $nomep . "%' AND g.codg LIKE '%" . $codg . "%'
				AND g.nome LIKE '%" . $nomeg . "%' AND l.codl LIKE '%" . $codl . "%' AND l.nome LIKE '%" . $nomel . "%'
				ORDER BY e.data";

	$SaidaRes = query($conexao, $Saida);
	$NSaidaRes = mysqli_num_rows($SaidaRes);


	$EntradaRes = query($conexao, $Entrada);
	$NEntradaRes = mysqli_num_rows($EntradaRes);

	if (($NSaidaRes<=0 && $NEntradaRes<=0) || (!$saidaF && !$entradaF) ||
			($saidaF && !$entradaF && $NSaidaRes == 0) || (!$saidaF && $entradaF && $NEntradaRes == 0)) {
		echo '<p>Nenhum produto encontrado.</p>';
	}else if (!$saidaF && $entradaF){
		while ($row = mysqli_fetch_assoc($EntradaRes)) {
			echo "<tr>";
			echo "<td><center>". $row['codp'] . "</center></td> <td>". $row['nomep'] . "</td>
			<td><center>" . $row['qtd'] . "</center></td> <td><center>" . $row['nomeg'] . "</center></td>
			<td><center>" . $row['nomel']."</center></td>
			<td><center>". $row['datae']."</center></td>
			<td><center>---" ;
			echo "</tr> <br/>";
		}
	}else if ($saidaF && !$entradaF){
		while ($row = mysqli_fetch_assoc($SaidaRes)) {
			echo "<tr>";
			echo "<td><center>". $row['codp'] . "</center></td> <td>". $row['nomep'] . "</td>
			<td><center>" . $row['qtd'] . "</center></td> <td><center>" . $row['nomeg'] . "</center></td>
			<td><center>" . $row['nomel']."</center></td>
			<td><center>---</center></td>
			<td><center>" . $row['datas'];
			echo "</tr> <br/>";
		}
	}else if ($saidaF && $entradaF){
		$rowS = mysqli_fetch_assoc($SaidaRes);
		$rowE = mysqli_fetch_assoc($EntradaRes);
		while ($rowS || $rowE){
			if ($rowE && $rowS){
				if ($rowE['datae'] <= $rowS['datas']){
					echo "<tr>";
					echo "<td><center>". $rowE['codp'] . "</center></td> <td>". $rowE['nomep'] . "</td>
					<td><center>" . $rowE['qtd'] . "</center></td> <td><center>" . $rowE['nomeg'] . "</center></td>
					<td><center>" . $rowE['nomel']."</center></td>
					<td><center>". $rowE['datae']."</center></td>
					<td><center>---" ;
					echo "</tr> <br/>";
					$rowE = mysqli_fetch_assoc($EntradaRes);
				}else{
					echo "<tr>";
					echo "<td><center>". $rowS['codp'] . "</center></td> <td>". $rowS['nomep'] . "</td>
					<td><center>" . $rowS['qtd'] . "</center></td> <td><center>" . $rowS['nomeg'] . "</center></td>
					<td><center>" . $rowS['nomel']."</center></td>
					<td><center>---</center></td>
					<td><center>" . $rowS['datas'];
					echo "</tr> <br/>";
					$rowS = mysqli_fetch_assoc($SaidaRes);
				}
			}else if ($rowE){
				echo "<tr>";
				echo "<td><center>". $rowE['codp'] . "</center></td> <td>". $rowE['nomep'] . "</td>
				<td><center>" . $rowE['qtd'] . "</center></td> <td><center>" . $rowE['nomeg'] . "</center></td>
				<td><center>" . $rowE['nomel']."</center></td>
				<td><center>". $rowE['datae']."</center></td>
				<td><center>---" ;
				echo "</tr> <br/>";
				$rowE = mysqli_fetch_assoc($EntradaRes);
			}else{
				echo "<tr>";
				echo "<td><center>". $rowS['codp'] . "</center></td> <td>". $rowS['nomep'] . "</td>
				<td><center>" . $rowS['qtd'] . "</center></td> <td><center>" . $rowS['nomeg'] . "</center></td>
				<td><center>" . $rowS['nomel']."</center></td>
				<td><center>---</center></td>
				<td><center>" . $rowS['datas'];
				echo "</tr> <br/>";
				$rowS = mysqli_fetch_assoc($SaidaRes);
			}
		}
	}

?>
