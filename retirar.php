<?php
	require ("connect.php");

	if(!isset($_SESSION['name'])){
		header("Location:index.php");
	}
	mysqli_autocommit($conexao,False);

	if(isset($_POST['retirarprod'])){
		$codp = $_POST['codigo'];
		$nome = $_POST['nome'];
		$qtdade = $_POST['qtdade'];
		$data = $_POST['data'];
		$destino = $_POST['destino'];
		$chamado = $_POST['chamado'];
		$origem = $_POST['codl'];
		if(isset($_POST['trans']) && isset($_POST['transferencia'])){
			$trans = $_POST['trans'];//codl
			$valor = $_POST['valor'];
			$busca = "SELECT * FROM localizacao WHERE codp = '$codp' AND codl = '$trans'";
			$busca1= "SELECT * FROM localizacao WHERE codp = '$codp' AND codl ='$origem'";

			$resultado = mysqli_query($conexao,$busca);
			$resultado1 = mysqli_query($conexao,$busca1);

			$dados = mysqli_fetch_array($resultado);
			$dados1 = mysqli_fetch_array($resultado1);

			$qtdade1 = $dados['qtd'] + $qtdade;
			$qtdade2 = $dados1['qtd'] - $qtdade;

			$sql  = "UPDATE localizacao SET qtd = '$qtdade1' WHERE codp ='$codp' AND codl = '$trans'";
			$sql1 = "UPDATE localizacao SET qtd = '$qtdade2' WHERE codp ='$codp' AND codl = '$origem'";

			$resultado = mysqli_query($conexao,$sql);
			$resultado1 = mysqli_query($conexao,$sql1);

			$sql = "INSERT INTO remocao(data,qtd,codp,destino,chamado) VALUES ('$data', '$qtdade' ,'$codp','$trans','Transferência')";
			$sql1 = "INSERT INTO insercao(codp,qtd,data,vlr,tipo) VALUES ('$codp','$qtdade','$data', '$valor', 'Transferência')";
			try {
				$a = mysqli_commit($conexao);
				if(!$a)
					throw new Exception("Não commitado no banco, tente novamente", 1);
			} catch (Exception $e) {
				$_SESSION['msg'] = $e->getMessage();
					mysqli_rollback($conexao);
			}
			
		}else{
			$busca = "SELECT * FROM localizacao WHERE codp = '$codp' AND codl = '$origem'";
			$resultado = mysqli_query($conexao,$busca);
			$dados = mysqli_fetch_array($resultado);			
			$qtdade1 = $dados['qtd'] - $qtdade;
			
			if ($qtdade1 >= 0) {
				try{
					$sql = "INSERT INTO remocao(data,qtd,codp,destino,chamado) VALUES ('$data', '$qtdade' ,'$codp','$destino','$chamado')";

					$cons = mysqli_query($conexao, $sql);					

					$sql1 = "UPDATE localizacao SET qtd = '$qtdade1' WHERE codp ='$codp' AND codl = '$origem'";
					$cons1 = mysqli_query($conexao, $sql1);

					if(!$cons){
						$_SESSION['msg']=$qtdade.' de '.$nome.' não pode ser removidas.<br/><p style="color:red;">Erro: '.mysqli_error($conexao).'</p>';
						throw new Exception($_SESSION['msg'], 1);
					}
					else
						$_SESSION['msg']=$qtdade." unidades de ".$nome." foram retiradas com sucesso.";


					$a = mysqli_commit($conexao);
					if(!$a)
						throw new Exception("Não commitado no banco, tente novamente", 1);

					$a = mysqli_commit($conexao);
					if(!$a)
						throw new Exception("Não commitado no banco, tente novamente", 1);

				}catch(Exception $e ){
					$_SESSION['msg'] = $e->getMessage();
					mysqli_rollback($conexao);
				}
			}else

					$_SESSION['msg']="Preste atenção na quantidade disponível. Você está retirando mais produtos do que há.";
		}
	}
	mysqli_autocommit($conexao,True);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Formulário Remoção</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

		<script type="text/javascript">					
			function ativatransferencia(){
				if(document.getElementById("idtransferencia").checked){
					document.getElementById("trans").style.display= "block";
				}else
					document.getElementById("trans").style.display= "none";
			}	

            
		</script>
	</head>
	<body>

		<div class="container">

			<?php require_once ("menu-principal.php"); ?>

			<div class="col-sm-12">
				<h3><b>Remover unidades de Produto</b></h3>
				<form action="retirar.php?prod=<?php echo $_GET['prod']; ?>" method="post" class="form-horizontal">
					<div class="form-group row">
						<div class="col-xs-3">
							<label for="idCodigo">Código do Produto:</label>
							<input type="text" id="idCodigo" name="codigo" readonly="readonly"
							<?php
								if(isset($_GET['prod']))
									echo 'value="' . $_GET['prod'] . '"';
							?> class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-3">
							<label for="idNome">Nome do Produto:</label>
							<input type="text" id="idNome" name="nome" readonly="readonly"
							<?php
								if(isset($_GET['prod'])){
									$produto = $_GET['prod'];
									$busca = "SELECT nome FROM produto WHERE cod = '$produto'";
									$resultado = mysqli_query($conexao, $busca);
									$dados = mysqli_fetch_array($resultado);
									echo '	value="' . $dados["nome"] . '"';
								}
							?> class="form-control">
						</div>
					</div>

					<div class="form-group row">
				    <div class="col-xs-3">
							<label>Origem</label>
								<?php 
									$local = $_SESSION['local'];
									if($_SESSION['funcao']=="Administrador"){
										$busca = "SELECT * FROM local"; 
										$resultado = mysqli_query($conexao, $busca);
										echo'<select name="codl">';
										while($dados = mysqli_fetch_array($resultado)){										
											echo '<option value="'.$dados['codl'].'">'.$dados['nome'].'</option>';
										}
										echo'</select><br/>';
									}else{
										$busca = "SELECT * FROM local"; 
										$resultado = mysqli_query($conexao, $busca);
										$dados = mysqli_fetch_assoc($resultado);
											echo '<input type="text" value="'.$dados['nome'].'" readonly/>';
											echo '<input type="text" name="codl" value="'.$dados['codl'].'" style="display:none"/>';
									}
								?>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-3">
							<label for="idQtd">Quantidade:</label>
							<input id="idQtd" type="number" min="1" name="qtdade" class="form-control" required="required">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-3">
							<label for="idData">Data:</label>
							<input type="date" id="idData" name="data" value=
								<?php
									echo '"' . date('Y-m-d H:i') . '"';
								?> class="form-control" required="required">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-3">
							<label for="idDestino">Destino:</label>
							<input id="idDestino" type="text" name="destino" class="form-control" required="required">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-3">
							<label for="idChamado">Chamado:</label>
							<input id="idChamado" type="text" name="chamado" class="form-control">
						</div>
					</div>
							
					<label class="checkbox-inline">
					  <input type="checkbox" id="idtransferencia" name ="transferencia" value="t" onchange="ativatransferencia();"> Transferência
					</label>
					<div class="form-group row" id="trans" style="display:none;">
				    <div class="col-xs-3">
							<label>Destino2:</label>
							<select name="trans">
								<?php 
									$busca = "SELECT * FROM local"; 
									$resultado = mysqli_query($conexao, $busca);
									$i=0;
									while($dados = mysqli_fetch_array($resultado)){
										$i++;
										echo '<option value="' . $dados["codl"] . '"> '.$dados['codl'].': '.$dados['nome'].'</option>';
									}

								?>
							</select>
							<br />Valor: <input type="number" name="valor"/>
						</div>
					</div>
					<br /><br />
					<input type="submit" name="retirarprod" value="Retirar" class="btn btn-primary">
				</form>
				<?php
					if(isset($_SESSION['msg'])){
						echo $_SESSION['msg'];
						unset($_SESSION['msg']);
					}
				?>
			</div>
			<a href="buscas.php"><button><b>Nova Busca</b></button></a>
		</div>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>

	</body>
</html>
