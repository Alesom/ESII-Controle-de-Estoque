<?php
	require ("connect.php");

	if(!isset($_SESSION['name'])){
		header("Location:index.php");
	}
	//desativar o autocommit para quando o php try, as alterações não corretas não vão diretamente para o banco.
	mysqli_autocommit($conexao, FALSE);

	if(isset($_POST['insertprod'])){
		$codp = $_POST['codigo'];
		$nome = $_POST['nome'];
		$qtdade = $_POST['qtdade'];
		$data = $_POST['data'];
		$sql = "INSERT INTO insercao VALUES ('$codp','$qtdade','$data')";

		$busca = "SELECT qtd FROM produto WHERE cod = '$codp'";
		$resultado = mysqli_query($conexao, $busca);
		$dados = mysqli_fetch_array($resultado);
		$new_qtd = $dados["qtd"] + $qtdade;
		$sql1 = "UPDATE produto SET qtd = '$new_qtd' WHERE cod = '$codp'";

		try {
			$cons = mysqli_query($conexao ,$sql);
		  $cons1 = mysqli_query($conexao ,$sql1);
		  if(!$cons || !$cons1){
		  	throw new Exception("na inserção", 1);
		  }
		  if(!$cons)
				$_SESSION['msg']='O produto'.$nome.' não pode ser inserido.<br/><p style="color:red;">Erro: '.mysqli_error($conexao).'</p>';
			else
				$_SESSION['msg']=$qtdade." unidades de ".$nome." foram inseridas com sucesso.";

				$a = mysqli_commit($conexao);
		    if(!$a)	throw new Exception("Não foi possivel efetivar a inserção, problema com o banco. Consulte Administrador", 1);
		} catch (Exception $e) {
		    echo 'Ocorreu um erro: ',  $e->getMessage(), "\n";
		}
	}
	mysqli_autocommit($conexao, TRUE);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Formulário Inserção</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	</head>
	<body>

		<div class="container">

			<?php require_once ("menu-principal.php"); ?>

			<div class="col-sm-12">
				<h3><b>Dar Entrada em Unidades do Produto</b></h3>
				<form action="inserir.php?prod=<?php echo $_GET['prod']; ?>" method="post" class="form-horizontal">
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
					<input type="submit" name="insertprod" value="Inserir" class="btn btn-primary">
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
