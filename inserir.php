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
		$cnpj = $_POST['cnpj'];
		$valor = $_POST['valor'];
		$nfe = $_POST['nfe'];
		$codl = $_POST['codl'];
		$tipo = $_POST['tipo_entrada'];
		$sql = "INSERT INTO insercao VALUES ('$codp','$qtdade','$data','$cnpj', '$valor', '$nfe', '$tipo')";

		$insercao = "INSERT IGNORE INTO localizacao(`codp`,`codl`,`qtd`, `qtdmin`, `alarm`)
								VALUES ('" . $codp . "', " . $codl . ", 0, 0, 1);";
		$insere = mysqli_query($conexao,$insercao);

		$busca = "SELECT * FROM localizacao WHERE codp = '$codp' AND codl ='$codl' ";
		$resultado = mysqli_query($conexao, $busca);
		$dados = mysqli_fetch_array($resultado);
		$new_qtd = $dados["qtd"] + $qtdade;
		$sql1 = "UPDATE localizacao SET qtd = '$new_qtd' WHERE codp = '$codp' and codl='$codl'";

		try {
			$cons = mysqli_query($conexao ,$sql);
			$cons1 = mysqli_query($conexao ,$sql1);
			if(!$cons || !$cons1){
				if(!$cons)
					$_SESSION['msg']='<p>O produto '.$nome.' não pode ser inserido na tabela inserção.<br/></p><p style="color:red;">'.mysqli_error($conexao).'</p>';
				if(!$cons1)
					$_SESSION['msg']='<p>O produto 	'.$nome.' não pode ser inserido na tabela local.<br/></p><p style="color:red;">'.mysqli_error($conexao).'</p>';

				throw new Exception("Erro: ".$_SESSION['msg'], 1);
			}else{
				$a = mysqli_commit($conexao);
    		if(!$a)
    			throw new Exception("Não foi possivel efetivar a inserção, problema com o banco. Consulte Administrador", 1);
    		else {
    			$_SESSION['msg']='O produto foi inserido com sucesso.';
    		}
			}
		} catch (Exception $e) {
			mysqli_rollback($conexao);
		    $_SESSION['msg'] = $e->getMessage();
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
				<h3><b>Dar entrada em unidades do produto</b></h3>
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
							<input type="number" min="1" name="qtdade" class="form-control" required="required" placeholder="Quantidade">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-3">
							<input type="number" step="0.01" name="valor" class="form-control" required="required" placeholder="Valor da Entrada">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-3">
							<input type="text" name="nfe" class="form-control" required="required" placeholder="Número da Nota Fiscal">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-3">
							<label for="idQtd">Fornecedor:</label>
							<select name="cnpj" class="form-control" id="fornecedor">
							<option>Selecione</option>
								<?php
									$busca = "SELECT * FROM fornecimento NATURAL JOIN fornecedor WHERE cod = '$produto'";
									$resultado = mysqli_query($conexao, $busca);
									$i=0;
									while($dados = mysqli_fetch_array($resultado)){
										$i++;
										echo '<option value="' . $dados["cnpj"] . '"> '.$dados['razao_social'].': '.$dados['cnpj'].'</option>';
									}

								?>
							</select>
							<?php
								if($i==0){
									echo '<br/><a href="configurar.php?prod='.$produto.'">Adicionar fornecedor ao produto</a>';
								}
							?>

						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-3">
					    <label for="tp_entrada">Tipo de Entrada:</label>
					    <select class="form-control" id="tp_entrada" name="tipo_entrada" onchange="VrTrans();">
								<option>Selecione</option>
								<option value="Compra">Compra</option>
								<option value="Doação">Doação</option>
					    </select>
						</div>
				  </div>

					<div class="form-group row">
				    <div class="col-xs-3">
							<label>Local:</label>
								<?php
									$local = $_SESSION['local'];
									$busca = "SELECT * FROM local";
									$resultado = mysqli_query($conexao, $busca);

									if($_SESSION['funcao']=="Administrador"){
										echo'<select class="form-control" name="codl">';
										while($dados = mysqli_fetch_array($resultado)){
											echo '<option value="'.$dados['codl'].'">'.$dados['nome'].'</option>';
										}
									}else{
										$dados = mysqli_fetch_assoc($resultado);
										echo'<select class="form-control" name="codl">';
										echo '<option value="'.$dados['codl'].'">'.$dados['nome'].'</option>';
									}
									echo'</select>';
								?>
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
					</br></br>
		  	</form>

			</div>
			<?php
				if(isset($_SESSION['msg'])){
					$mensagem = substr($_SESSION['msg'], -8);
					if (strcmp($mensagem, "sucesso.") == 0) {
						echo '<div class="alert alert-success">' . $_SESSION['msg'] . '</div>';
					} else {
						echo '<div class="alert alert-danger">' . $_SESSION['msg'] . '</div>';
					}
					unset($_SESSION['msg']);
				}
			?>
		</div>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>

	</body>
</html>
