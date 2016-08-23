<?php
	session_cache_limiter('private');
	$cache_limiter = session_cache_limiter();

	//Limitando pra 30 min
	session_cache_expire(30);
	$cache_expire = session_cache_expire();

	session_start();

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