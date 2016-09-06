	<?php
	require_once 'inserts/functions.php';
	require_once 'inserts/logindb.php';

	$banco = conectadb($dbHostname, $dbUsername, $dbPassword);

	session_start();
	if(!isset($_SESSION['name'])){
		header("Location:index.php");
	}
	selectdb($banco, $dbDatabase);

	//percorrer todos os produtos e verificar se hÃ¡ algum com qtd menor ou igual a qtdmin.

	$a=0;				
	$sql = "SELECT * FROM produto WHERE qtd<=qtdmin";
	$res = mysqli_query($banco,$sql);
	while ($resu = mysqli_fetch_assoc($res)){
		$my[$a]=  array("nome"=>$resu['nome'],"valor"=>$resu['qtd'],"minimo"=>$resu['qtdmin']);
		$a++;
	}

	echo json_encode($my);
				
	
?>
