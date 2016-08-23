<?php

class estoque {

	function insere_grupo($codg,$nome){
		$cn= mysqli_connect( "127.0.0.1",  "admin", "123", "estoque");
		$sqlinsert = "INSERT INTO produto (codg, nome) VALUES ('$codg','$nome')";
		$cons = mysqli_query($cn ,$sqlinsert) or die ("MYSQL ERROR RESULTADO TABLE " .mysqli_error($cn));
	}

	function insere_insercao($codp, $qtd, $data){
		$cn= mysqli_connect( "127.0.0.1",  "admin", "123", "estoque");
		$sqlinsert = "INSERT INTO insercao (codp, qtd, data) VALUES ($codp, $qtd, '$data')";
		$cons = mysqli_query($cn ,$sqlinsert) or die ("MYSQL ERROR RESULTADO TABLE " .mysqli_error($cn));
	}

	function insere_local($codl, $nome){
		$cn= mysqli_connect( "127.0.0.1",  "admin", "123", "estoque");
		$sqlinsert = "INSERT INTO local (codl, nome) VALUES ('$codl', '$nome')";
		$cons = mysqli_query($cn ,$sqlinsert) or die ("MYSQL ERROR RESULTADO TABLE " .mysqli_error($cn));	
	}

	function insere_produto($cod, $nome, $qtd, $codg, $codl){
		$cn= mysqli_connect( "127.0.0.1",  "admin", "123", "estoque");
		$sqlinsert = "INSERT INTO produto (cod, nome, qtd, codg, codl) VALUES ( $cod, '$nome', $qtd, '$codg', '$codl' )";
		$cons = mysqli_query($cn ,$sqlinsert) or die ("MYSQL ERROR RESULTADO TABLE " .mysqli_error($cn));	
	}

	function insere_remocao($data, $qtd, $codp, $destino, $chamado ){
		$cn= mysqli_connect( "127.0.0.1",  "admin", "123", "estoque");
		$sqlinsert = "INSERT INTO remocao(data, qtd, codp, destino, chamado) VALUES ( '$data', $qtd, $codp, '$destino', '$chamado' )";
		$cons = mysqli_query($cn ,$sqlinsert) or die ("MYSQL ERROR RESULTADO TABLE " .mysqli_error($cn));	
	}

	function insere_usuario($cod, $nome, $funcao, $senha, $codl ){
		$cn= mysqli_connect( "127.0.0.1",  "admin", "123", "estoque");
		$sqlinsert = "INSERT INTO remocao( cod, nome, funcao, senha, codl) VALUES ( $cod, '$nome', '$funcao', '$senha', '$codl' )";
		$cons = mysqli_query($cn ,$sqlinsert) or die ("MYSQL ERROR RESULTADO TABLE " .mysqli_error($cn));	
	}

}
?>
