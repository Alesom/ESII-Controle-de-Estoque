<?php
	require ("connect.php");

	$codp = $_GET['codp'];
	$nomep = $_GET['nomep'];
	$codg = $_GET['codg'];
	$nomeg = $_GET['nomeg'];
	$codl = $_GET['codl'];
	$nomel = $_GET['nomel'];

	$query = "SELECT p.cod AS codp, p.nome AS nomep, lz.qtd AS qtd, g.nome AS nomeg, l.nome AS nomel
				FROM produto AS p INNER JOIN localizacao AS lz ON(p.cod = lz.codp) INNER JOIN local AS l on (lz.codl = l.codl) left JOIN grupo AS g  ON SUBSTRING(p.cod,1,1) = g.codg
				WHERE p.cod LIKE '%" . $codp . "%' AND p.nome LIKE '%" . $nomep . "%' AND g.codg LIKE '%" . $codg . "%'
				AND g.nome LIKE '%" . $nomeg . "%' AND l.codl LIKE '%" . $codl . "%' AND l.nome LIKE '%" . $nomel . "%'
				ORDER BY p.cod";

	$resultado = query($conexao, $query);
	$num = mysqli_num_rows($resultado);

	if ($num>0) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			echo "<tr>";
 			echo "<td><center>". $row['codp'] . "</center></td> <td>". $row['nomep'] . "</td>
 			<td><center>" . $row['qtd'] . "</center></td> <td><center>" . $row['nomeg'] . "</center></td>
			<td><center>" . $row['nomel'] . "</center></td>" .
			"<td><a class='btn btn-primary' href='inserir.php?prod=" . $row['codp'] . "' role='button'>" .
			"<span class='glyphicon glyphicon-plus' aria-hidden='true'></span></a></td>" .
			"<td><a class='btn btn-primary' href='retirar.php?prod=" . $row['codp'] . "' role='button'>" .
			"<span class='glyphicon glyphicon-minus' aria-hidden='true'></span></a></td>" .
			"<td><a class='btn btn-primary' href='configurar.php?prod=" . $row['codp'] . "' role='button'>" .
			"<span class='glyphicon glyphicon-cog' aria-hidden='true'></span></a></td>";
 			echo "</tr>";
		}
	} else {
		echo '<p>Nenhum produto encontrado.</p>';
	}
?>
