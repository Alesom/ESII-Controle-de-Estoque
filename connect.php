<?php

	$temposessao = 3600; //em segundos
	session_start(); 
	if (isset($_SESSION["sessiontime"])) {
	 	if ($_SESSION["sessiontime"] < (time() - $temposessao)) {
	 		session_unset();
//	 		echo "Seu tempo Expirou!";	
	 	} 
	}else{
		session_unset();
	}
	$_SESSION["sessiontime"] = time();
	

	/*Definir Padrão e em seguida configurar todas as maquinas:

	$host="127.0.0.1"; 	|| 	$host="localhost"; 
	$admin="admin"; 	||	$admin="uffs";		||	$admin="po";
	$pass="123";		||	$pass="";//sugestão
	$db="estoque";
	*/

	$host = "localhost";
	$bd = "estoque";
	$user = "root";
	$pass = "";

	$conexao = mysqli_connect($host,$user,$pass,$bd) or die(mysql_error());

?>