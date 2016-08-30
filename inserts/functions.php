<?php
	function conectadb($dbHostname, $dbUsername, $dbPassword){
		$con = mysqli_connect($dbHostname, $dbUsername, $dbPassword);
		if(!$con) {
			die("Não foi possível conectar ao MySQL: " . mysqli_error($con));
	 	}
	 	return $con;
	}

	function selectdb($con, $db) {
		mysqli_select_db($con, $db)
	 		or die("Não foi possível selecionar a base de dados: ".mysqli_error($con));
	}

	function query($con, $query) {

		$result = mysqli_query($con, $query);

		if (!$result) {
			die ("Falha de acesso à base: " . mysqli_error($con) . mysqli_errno($con));
		}
		return $result;
	}
?>