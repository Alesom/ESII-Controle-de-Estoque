<!DOCTYPE html>
<?php session_start();
/*
<head> 
	<title>Formulário Cadastro</title> 
	<meta charset="utf-8" /> 
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
</head> 
*/
	<form action="produto.php" method="post">
        <p>codigo: <input type="text" name="codigo" /></p>
 	<p>nome: <input type="text" name="nome" /></p>
	<p>quantidade: <input type="text" name="qtdade" /></p>
	<p>codigo grupo: <input type="text" name="codgrupo" /></p>
	<p>codigo local: <input type="text" name="codlocal" /></p>
 	<p><input type="submeter" /></p>
	</form> 


?>