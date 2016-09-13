<?php
	require ("connect.php");

	$codp = $_GET['codp'];
	$nomep = $_GET['nomep'];
	$codg = $_GET['codg'];
	$nomeg = $_GET['nomeg'];
	$codl = $_GET['codl'];
	$nomel = $_GET['nomel'];
	$ano = $_GET['ano'];
	$saida = $_GET['saida'];
	$entrada = $_GET['entrada'];

#	$query = "SELECT p.cod AS codp, p.nome AS nomep, p.qtd AS qtd, g.nome AS nomeg, l.nome AS nomel 
#				FROM produto AS p INNER JOIN grupo AS g on (p.codg = g.codg) INNER JOIN local AS l on (p.codl = l.codl)
#				WHERE p.cod LIKE '%" . $codp . "%' AND p.nome LIKE '%" . $nomep . "%' AND g.codg LIKE '%" . $codg . "%' 
#				AND g.nome LIKE '%" . $nomeg . "%' AND l.codl LIKE '%" . $codl . "%' AND l.nome LIKE '%" . $nomel . "%'
#				ORDER BY p.cod";

	$query = "SELECT p.cod AS codp, p.nome AS nomep, p.qtd AS qtd, g.nome 
							AS nomeg, l.nome AS nomel, s.data AS datas, e.data AS datae, e.codp 
							AS ecodp, s.codp AS scodp 
				FROM insercao AS e CROSS JOIN remocao AS s
				INNER JOIN produto AS p on (p.cod = s.codp or p.cod =e.codp)
				INNER JOIN grupo AS g on (p.codg = g.codg) 
				INNER JOIN local AS l on (p.codl = l.codl)
				WHERE p.cod LIKE '%" . $codp . "%' AND p.nome LIKE '%" . $nomep . "%' AND g.codg LIKE '%" . $codg . "%' 
				AND g.nome LIKE '%" . $nomeg . "%' AND l.codl LIKE '%" . $codl . "%' AND l.nome LIKE '%" . $nomel . "%'
				ORDER BY e.data, s.data";

	$resultado = query($conexao, $query);
	$num = mysqli_num_rows($resultado);

	if ($num>0) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			echo "<tr>";
			echo "<td><center>". $row['codp'] . "</center></td> <td>". $row['nomep'] . "</td> 
			<td><center>" . $row['qtd'] . "</center></td> <td><center>" . $row['nomeg'] . "</center></td> 
			<td><center>" . $row['nomel']."</center></td> 
			<td><center>" . $row['datae']."</center></td> 
			<td><center>" . $row['datas'];
			echo "</tr> <br/>";
		}
	} else {
		echo '<p>Nenhum produto encontrado.</p>';
	}
?>