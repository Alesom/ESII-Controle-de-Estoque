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


		$busca= "SELECT qtd FROM produto WHERE cod = '$codp'";
		$resultado = mysqli_query($conexao,$busca);
		$dados = mysqli_fetch_array($resultado);
		$new_qtd = $dados["qtd"] - $qtdade;

		$sql1 = "UPDATE produto SET qtd = '$new_qtd' WHERE cod = '$codp'";
		$sql = "INSERT INTO remocao VALUES ('$data', '$qtdade' ,'$codp','$destino','$chamado')";

		if ($new_qtd >= 0) {
			try{
				$cons1 = mysqli_query($conexao, $sql1);
				$cons = mysqli_query($conexao, $sql);

				if(!$cons1 || !$cons)
					throw new Exception("Errrouuuu", 1);

				if(!$cons)
					$_SESSION['msg']=$qtdade.' de '.$nome.' não pode ser removidas.<br/><p style="color:red;">Erro: '.mysqli_error($conexao).'</p>';
				else
					$_SESSION['msg']=$qtdade." unidades de ".$nome." foram retiradas com sucesso.";

				$a = mysqli_commit($conexao);
				if(!$a)
					throw new Exception("Não commitado no banco, tente novamente", 1);
			}catch(Exception $e ){
				echo "Deu erro nessa porra".$e->getMessage();
				mysqli_rollback($conexao);
			}
		}else
				$_SESSION['msg']="Preste atenção na quantidade disponível. Você está retirando mais produtos do que há.";
	}
	mysqli_autocommit($conexao,True);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Formulário Remoção</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
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
					<input type="submit" name="retirarprod" value="Retirar" class="btn btn-primary">
					
					<label class="checkbox-inline">
					  <input type="checkbox" id="idtransferencia" value="t" checked="checked" onclick="ativatransferencia(0)"> Transferência
					</label>
					
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
