<?php
	require_once 'inserts/functions.php';
	require_once 'inserts/logindb.php';

	$banco = conectadb($dbHostname, $dbUsername, $dbPassword);

	selectdb($banco, $dbDatabase);

	//percorrer todos os produtos e verificar se há algum com qtd menor ou igual a qtdmin.
	$sql = "SELECT * FROM produto WHERE qtd<=qtdmin";
	$res = mysqli_query($banco,$sql);
	while ($resu = mysqli_fetch_assoc($res))
		echo '<p> Restam apenas '.$resu['qtd'].' do produto: <b>'.$resu['nome'].'</b> a quantidade minima configurada é de '.$resu['qtdmin'].'</p>';
	
?>