<?php
	require_once 'inserts/functions.php';
	require_once 'inserts/logindb.php';
	$banco = conectadb($dbHostname, $dbUsername, $dbPassword);
	mysqli_autocommit($banco, FALSE);
	selectdb($banco, $dbDatabase);
	

	if(isset($_POST['retirarprod'])){
		$codp = $_POST['codigo'];
		$nome = $_POST['nome'];
		$qtdade = $_POST['qtdade'];
		$data = $_POST['data'];
		$destino = $_POST['destino'];
		$chamado = $_POST['chamado'];


		$busca= "SELECT qtd FROM produto WHERE cod = '$codp'";
		$resultado = mysqli_query($banco,$busca);
		$dados = mysqli_fetch_array($resultado);
		$new_qtd = $dados["qtd"] - $qtdade;

		if($new_qtd>=0){

			$sql1 = "UPDATE produto SET qtd = '$new_qtd' WHERE cod = '$codp'";
			$sql = "INSERT INTO remocao VALUES ('$data', '$qtdade' ,'$codp','$destino','$chamado')";
			try{
				$cons1 = mysqli_query($banco ,$sql1);
				$cons = mysqli_query($banco ,$sql);
				
				if(!$cons1 || !$cons)
					throw new Exception("Errrouuuu", 1);
					
				if(!$cons)
				$_SESSION['msg']=$qtdade.' de '.$nome.' não pode ser removidas.<br/><p style="color:red;">Erro: '.mysqli_error($banco).'</p>';
				else
					$_SESSION['msg']=$qtdade." unidades de ".$nome." foram retiradas com sucesso.";

				$a = mysqli_commit($banco);
				if(!$a)
					throw new Exception("Não commitado no banco, tente novamente", 1);
					
				
			
			}catch(Exception $e ){
				echo "Deu erro nessa porra".$e->getMessage();
			}
		}else
				$_SESSION['msg']="Preste atenção na quantidade disponível. Você está retirando mais produtos do que há.";

	}
?>
<!DOCTYPE html>
<html>
<head> 
	<title>Formulário Remoção</title> 
	<meta charset="utf-8" />
</head> 
<body>
	<div id="cadp" align="center">
	
		<label><b>Remover unidades de Produto</b></label>
		<form action=<?echo '"retirar.php?prod='.$_GET['prod'].'"';?> method="post">	

		    Código do produto:<input type="text" name="codigo" readonly="readonly" <?if(isset($_GET['prod']))echo 'value="'.$_GET['prod'].'"';else echo'placeholder="Código do Produto"'?> /><br/>
		    Nome do produto:<input type="text" name="nome" readonly="readonly"
		    	<?php if(isset($_GET['prod'])){
		    		$produto = $_GET['prod'];
					$busca= "SELECT nome FROM produto WHERE cod = '$produto'";
					$resultado = mysqli_query($banco,$busca);
					$dados = mysqli_fetch_array($resultado);
					//echo $dados[0];
					echo '	value="'.$dados["nome"].'"';

		    	}?> /><br/>
			Quantidade:<input type="text" name="qtdade" placeholder="00" />
			<?php 
		    		$produto = $_GET['prod'];
					$busca= "SELECT qtd FROM produto WHERE cod = '$produto'";
					$resultado = mysqli_query($banco,$busca);
					$dados = mysqli_fetch_array($resultado);
					//echo $dados[0];
					echo '	<text><b>['.$dados["qtd"].'] </b>unidades disponiveis</text>';

		    	?><br/>
			Data: <input type="date" name="data" /><br/>
			Destino:<input type="text" name="destino"/><br/>
			Chamado:<input type="text" name="chamado"/><br/>
			
		 	<input type="submit" name="retirarprod" value="Retirar"/>
		 	
		</form> 
		<?if(isset($_SESSION['msg'])){echo $_SESSION['msg'];unset($_SESSION['msg']);}?>
	</div>
	<a href="buscas.php"><button><b>Nova Busca</b></button></a> 

</body>
</html>



