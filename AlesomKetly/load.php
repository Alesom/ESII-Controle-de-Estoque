<?php
	$pesquisa = $_GET['valor'];

	require_once 'inserts/functions.php';
	require_once 'inserts/logindb.php';

	$banco = conectadb($dbHostname, $dbUsername, $dbPassword);

	selectdb($banco, $dbDatabase);
	
	$query = "SELECT p.cod AS codp, p.nome AS nomep, p.qtd AS qtd, g.nome AS nomeg, l.nome AS nomel 
				FROM produto AS p INNER JOIN grupo AS g on (p.codg = g.codg) INNER JOIN local AS l on (p.codl = l.codl)
				WHERE p.cod LIKE '%" . $pesquisa . "%' ORDER BY p.cod";

	$resultado = query($banco, $query);
	$num = mysqli_num_rows($resultado);

	if ($num>0) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			echo $row['codp'] . " " . $row['nomep'] . " " . $row['qtd'] . " " . $row['nomeg']
			 . " " . $row['nomel'] . '<br/>';
		}
	} else {
		echo '<p>Nenhum produto encontrado.</p>';
	}
?>